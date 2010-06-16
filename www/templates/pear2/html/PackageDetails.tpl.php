<?php

switch ($context->stability['release']) {
case 'alpha':
    $statusClass = 'package-alpha';
    break;
case 'beta':
    $statusClass = 'package-beta';
    break;
default:
    $statusClass = 'package-stable';
    break;
}

$releaseDateISO = $context->date . 'T' . $context->time;
$releaseDate    = date('F j, Y', strtotime($releaseDateISO));

$licenseName  = htmlspecialchars($context->license['name']);
$licenseURI   = \PEAR2Web\License::getLink($context->license['name']);
$licenseClass = \PEAR2Web\License::isValid($context->license['name']) ?
    'package-license-good' : 'package-license-bad';

?>

<table class="package-details">
    <tbody>
        <tr>
            <th>Status:</th>
            <td>
                <?php echo $context->version['release']; ?>
                <span class="<?php echo $statusClass; ?>"><?php echo $context->stability['release']; ?></span>,
                released on <abbr class="date" title="<?php echo $releaseDateISO; ?>"><?php echo $releaseDate; ?></abbr>
            </td>
        </tr>
        <tr>
            <th>License:</th>
            <td>
<?php

if ($licenseURI) {
    echo '<a href="' . $licenseURI . '" class="' . $licenseClass . '">';
}
echo $licenseName;
if ($licenseURI) {
    echo '</a>';
}

?>
            </td>
        </tr>
        <!-- tr>
            <th>Bugs:</th>
            <td></td>
        </tr -->
        <!-- tr>
            <th>Maintainers:</th>
            <td></td>
        </tr -->
    </tbody>
</table>
