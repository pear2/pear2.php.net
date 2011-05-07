<a href="https://github.com/pear2/<?php echo $parent->context->name; ?>/issues" class="package-bugs-open">open bugs</a>,
<a href="https://github.com/pear2/<?php echo $parent->context->name; ?>/issues?state=closed" class="package-bugs-closed">closed</a>
<a href="https://github.com/pear2/<?php echo $parent->context->name; ?>/issues/new" class="package-bugs-new button button-small">Report New</a>
<script type="text/javascript">
$.getJSON('http://github.com/api/v2/json/issues/list/pear2/<?php echo $parent->context->name; ?>/open?callback=?',
        function(data){
            $('.package-bugs-open').html(data.issues.length + ' open');
        }
);
$.getJSON('http://github.com/api/v2/json/issues/list/pear2/<?php echo $parent->context->name; ?>/closed?callback=?',
        function(data){
            $('.package-bugs-closed').html(data.issues.length + ' closed');
        }
);

</script>