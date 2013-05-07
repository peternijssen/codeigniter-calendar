<table>
    <thead>
        <tr>
            <th class="text-left"><?php if(!empty($previous_link)) { ?><a href="<?php echo $previous_link; ?>"> << </a><?php } ?></th>
            <th class="text-center" colspan="5"><?php echo $month; ?> <?php echo $year; ?></th>
            <th class="text-right"><?php if(!empty($next_link)) { ?><a href="<?php echo $next_link; ?>"> >> </a><?php } ?></th>
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
        <td class="<?php echo (isset($day['today']) ? "today" : ""); ?>"><span><?php echo $day['day']; ?></span>
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