<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><a href=""></a></th>
            <th colspan="5"><?php echo $month; ?> <?php echo $year; ?></th>
            <th><a href=""></a></th>
        </tr>
        <tr>
            <?php foreach($daysofweek as $dow) { ?>
                <th><?php echo $dow; ?></th>
            <?php } ?> 
        </tr>
    </thead>
    <tbody>
    <?php foreach($weeks as $week) { ?>
    <tr>
        <?php foreach($week['days'] as $day) { ?>
        <td><?php echo $day['day']; ?>
            <?php if(isset($day['events'])) { ?>
                <ul>
                    <?php foreach($day['events'] as $event) { ?>
                        <li><a href="<?php echo $event['link']; ?>"><?php echo $event['name']; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
</table>