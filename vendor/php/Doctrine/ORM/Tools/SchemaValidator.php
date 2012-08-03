<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
*/

namespace Doctrine\ORM\Tools;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ManyToManyMapping;
use Doctrine\ORM\Mapping\OneToOneMapping;

/**
 * Performs strict validation of the mapping schema
 *
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.doctrine-project.com
 * @since       1.0
 * @version     $Revision$
 * @author      Benjamin Eberlei <kontakt@beberlei.de>
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Jonathan Wage <jonwage@gmail.com>
 * @author      Roman Borschel <roman@code-factory.org>
 */
class SchemaValidator
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Checks the internal consistency of mapping files.
     *
     * There are several checks that can't be done at runtime or are to expensive, which can be verified
     * with this command. For example:
     *
     * 1. Check if a relation with "mappedBy" is actually connected to that specified field.
     * 2. Check if "mappedBy" and "inversedBy" are consistent to each other.
     * 3. Check if "referencedColumnName" attributes are really pointing to primary key columns.
     *
     * @return array
     */
    public function validateMapping()
    {
        $errors = array();
        $cmf = $this->em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();

        foreach ($classes AS $class) {
            /* @var $class ClassMetadata */
            foreach ($class->associationMappings AS $fieldName => $assoc) {
                $ce = array();
                if (!$cmf->hasMetadataFor($assoc->targetEntityName)) {
                    $ce[] = "The target entity '" . $assoc->targetEntityName . "' specified on " . $class->name . '#' . $fieldName . ' is unknown.';
                }

                if ($assoc->mappedBy && $assoc->inversedBy) {
                    $ce[] = "The association " . $class . "#" . $fieldName . " cannot be defined as both inverse and owning.";
                }

                $targetMetadata = $cmf->getMetadataFor($assoc->targetEntityName);

                /* @var $assoc AssociationMapping */
                if ($assoc->mappedBy) {
                    if ($targetMetadata->hasField($assoc->mappedBy)) {
                        $ce[] = "The association " . $class->name . "#" . $fieldName . " refers to the owning side ".
                                "field " . $assoc->targetEntityName . "#" . $assoc->mappedBy . " which is not defined as association.";
                    }
                    if (!$targetMetadata->hasAssociation($assoc->mappedBy)) {
                        $ce[] = "The association " . $class->name . "#" . $fieldName . " refers to the owning side ".
                                "field " . $assoc->targetEntityName . "#" . $assoc->mappedBy . " which does not exist.";
                    } else if ($targetMetadata->associationMappings[$assoc->mappedBy]->inversedBy == null) {
                        $ce[] = "The field " . $class->name . "#" . $fieldName . " is on the inverse side of a ".
                                "bi-directional relationship, but the specified mappedBy association on the target-entity ".
                                $assoc->targetEntityName . "#" . $assoc->mappedBy . " does not contain the required ".
                                "'inversedBy' attribute.";
                    } else  if ($targetMetadata->associationMappings[$assoc->mappedBy]->inversedBy != $fieldName) {
                        $ce[] = "The mappings " . $class->name . "#" . $fieldName . " and " .
                                $assoc->targetEntityName . "#" . $assoc->mappedBy . " are ".
                                "incosistent with each other.";
                    }
                }

                if ($assoc->inversedBy) {
                    if ($targetMetadata->hasField($assoc->inversedBy)) {
                        $ce[] = "The association " . $class->name . "#" . $fieldName . " refers to the inverse side ".
                                "field " . $assoc->targetEntityName . "#" . $assoc->inversedBy . " which is not defined as association.";
                    }
                    if (!$targetMetadata->hasAssociation($assoc->inversedBy)) {
                        $ce[] = "The association " . $class->name . "#" . $fieldName . " refers to the inverse side ".
                                "field " . $assoc->targetEntityName . "#" . $assoc->inversedBy . " which does not exist.";
                    } else if ($targetMetadata->associationMappings[$assoc->inversedBy]->mappedBy == null) {
                        $ce[] = "The field " . $class->name . "#" . $fieldName . " is on the owning side of a ".
                                "bi-directional relationship, but the specified mappedBy association on the target-entity ".
                                $assoc->targetEntityName . "#" . $assoc->mappedBy . " does not contain the required ".
                                "'inversedBy' attribute.";
                    } else  if ($targetMetadata->associationMappings[$assoc->inversedBy]->mappedBy != $fieldName) {
                        $ce[] = "The mappings " . $class->name . "#" . $fieldName . " and " .
                                $assoc->targetEntityName . "#" . $assoc->inversedBy . " are ".
                                "incosistent with each other.";
                    }
                }

                if ($assoc->isOwningSide) {
                    if ($assoc instanceof ManyToManyMapping) {
                        foreach ($assoc->joinTable['joinColumns'] AS $joinColumn) {
                            if (!isset($class->fieldNames[$joinColumn['referencedColumnName']])) {
                                $ce[] = "The referenced column name '" . $joinColumn['referencedColumnName'] . "' does not " .
                                        "have a corresponding field with this column name on the class '" . $class->name . "'.";
                                break;
                            }

                            $fieldName = $class->fieldNames[$joinColumn['referencedColumnName']];
                            if (!in_array($fieldName, $class->identifier)) {
                                $ce[] = "The referenced column name '" . $joinColumn['referencedColumnName'] . "' " .
                                        "has to be a primary key column.";
                            }
                        }
                        foreach ($assoc->joinTable['inverseJoinColumns'] AS $inverseJoinColumn) {
                            $targetClass = $cmf->getMetadataFor($assoc->targetEntityName);
                            if (!isset($targetClass->fieldNames[$inverseJoinColumn['referencedColumnName']])) {
                                $ce[] = "The inverse referenced column name '" . $inverseJoinColumn['referencedColumnName'] . "' does not " .
                                        "have a corresponding field with this column name on the class '" . $targetClass->name . "'.";
                                break;
                            }

                            $fieldName = $targetClass->fieldNames[$inverseJoinColumn['referencedColumnName']];
                            if (!in_array($fieldName, $targetClass->identifier)) {
                                $ce[] = "The referenced column name '" . $inverseJoinColumn['referencedColumnName'] . "' " .
                                        "has to be a primary key column.";
                            }
                        }
                    } else if ($assoc instanceof OneToOneMapping) {
                        foreach ($assoc->joinColumns AS $joinColumn) {
                            $targetClass = $cmf->getMetadataFor($assoc->targetEntityName);
                            if (!isset($targetClass->fieldNames[$joinColumn['referencedColumnName']])) {
                                $ce[] = "The referenced column name '" . $joinColumn['referencedColumnName'] . "' does not " .
                                        "have a corresponding field with this column name on the class '" . $targetClass->name . "'.";
                                break;
                            }

                            $fieldName = $targetClass->fieldNames[$joinColumn['referencedColumnName']];
                            if (!in_array($fieldName, $targetClass->identifier)) {
                                $ce[] = "The referenced column name '" . $joinColumn['referencedColumnName'] . "' " .
                                        "has to be a primary key column.";
                            }
                        }
                    }
                }

                if ($ce) {
                    $errors[$class->name] = $ce;
                }
            }
        }

        return $errors;
    }

    /**
     * Check if the Database Schema is in sync with the current metadata state.
     *
     * @return bool
     */
    public function schemaInSyncWithMetadata()
    {
        $schemaTool = new SchemaTool($this->em);

        $allMetadata = $this->em->getMetadataFactory()->getAllMetadata();
        return (count($schemaTool->getUpdateSchemaSql($allMetadata, false)) == 0);
    }
}
