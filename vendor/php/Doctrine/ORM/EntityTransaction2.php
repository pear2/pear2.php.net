<?php
/*
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

namespace Doctrine\ORM;

use Exception;

/**
 * An EntityTransaction is an object-level transaction for a unit of work.
 * and is connected to the underlying unit of work of an EntityManager.
 *
 * @since 2.0
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 */
final class EntityTransaction
{
    /**
     * The EntityManager this transaction object is bound to.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $_em;

    /**
     * The underlying DBAL connection.
     *
     * @var Doctrine\DBAL\Connection
     */
    private $_conn;

    /**
     * Creates a new EntityTransaction that is bound to the given EntityManager.
     *
     * @param Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
        $this->_conn = $em->getConnection();
    }

    /**
     * Gets the underlying Connection on which this EntityTransaction operates.
     *
     * @return Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->_conn;
    }

    /**
     * Checks whether a transaction is currently active.
     *
     * @return boolean TRUE if a transaction is currently active, FALSE otherwise.
     */
    public function isActive()
    {
        return $this->_conn->isTransactionActive();
    }

    /**
     * Starts a transaction.
     */
    public function begin()
    {
        $this->_conn->beginTransaction();
    }

    /**
     * Commits the current transaction, writing any unflushed changes to the database.
     * If the commit fails, the running transaction is rolled back.
     *
     * @throws Doctrine\DBAL\ConnectionException If the commit failed due to no active transaction or
     *         because the transaction was marked for rollback only.
     * @throws Doctrine\ORM\OptimisticLockException If a version check on an entity that
     *         makes use of optimistic locking fails.
     */
    public function commit()
    {
        try {
            $this->_em->flush();
            $this->_conn->commit();
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * Rollback any database changes made during the current transaction.
     *
     * @throws Doctrine\DBAL\ConnectionException If the rollback operation failed.
     */
    public function rollback()
    {
        $this->_em->close();
        $this->_conn->rollback();
    }

    /**
     * Marks the current transaction so that the only possible
     * outcome for the transaction is to be rolled back.
     *
     * @throws Doctrine\DBAL\ConnectionException If no transaction is active.
     */
    public function setRollbackOnly()
    {
        $this->_conn->setRollbackOnly();
    }

    /**
     * Check whether the current transaction is marked for rollback only.
     *
     * @return boolean
     * @throws Doctrine\DBAL\ConnectionException If no transaction is active.
     */
    public function isRollbackOnly()
    {
        return $this->_conn->isRollbackOnly();
    }
}