<?php foreach ($hikings as $k => $v): ?>
    <tr>
        <th class="text-center"><img style="max-width: 250px;max-height: 150px;" src="<?php echo $v->getRandomImage(); ?>"></th>
        <td><?php echo $v->getName();?></td>


        <td><?php echo ($v->getStartDate())->format('Y-m-d H:i');?></td>
        <td><button class="btn btn-secondary">Szczegóły</button></td>
    </tr>
<?php endforeach; ?>
