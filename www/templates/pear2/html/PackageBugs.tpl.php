<?php

$openCount = $context->getGitHubIssueCount('open');

if ($openCount == 0) {
    echo '<span>none open</span>';
} else {
    echo '<a href="' . $context->getGitHubOpenIssuesLink() . '" class="package-bugs-open">' . $openCount . ' open</a>';
}

$closedCount = $context->getGitHubIssueCount('closed');

if ($closedCount > 0) {
    echo ', <a href="' . $context->getGitHubClosedIssuesLink() . '" class="package-bugs-closed">' . $closedCount . ' closed</a>';
}

?>
<div class="package-bugs-new">
    <a href="<?php echo $context->getGitHubNewIssueLink(); ?>" class="button button-small">Report New Issue on GitHub ↪</a>
</div>
