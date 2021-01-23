<?php foreach ($hikings as $k => $v): ?>
    <tr>
        <th class="text-center"><img style="max-width: 250px;max-height: 150px;" src="<?php echo $v->getRandomImage(); ?>"></th>
        <td><?php echo $v->getName();?></td>


        <td><?php echo ($v->getStartDate())->format('Y-m-d H:i');?></td>
        <td><a class="btn btn-secondary" style="color: white;" href="/profil-uzytkownika/wedrowki/<?php echo $v->getId();?>">Szczegóły</a></td>
    </tr>
<?php endforeach; ?>
