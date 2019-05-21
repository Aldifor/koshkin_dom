<div class="smile_head row border-success" id="smile_head">
<?php
$icons = [
    'standart' => '/img/smiles/standart/1.gif',
    'big_tigers' => '/img/smiles/big_tigers/29.gif',
    'pigs' => '/img/smiles/pigs/1.gif',
    'big_liss' => '/img/smiles/big_liss/42.gif',
    'monkeys' => '/img/smiles/monkeys/1.gif',
    'green_monkeys' => '/img/smiles/green_monkeys/1.gif',
    'bears' => '/img/smiles/bears/1.gif',
];
     foreach ($icons as $type => $url) {
         ?>
         <div>
            <img src="<?=$url?>"
                class="smile_type <?php if($type == "standart"){echo 'active_smile_type';}?>"
                name="smile_type"
            data-type="<?=$type?>">
         </div>
         <?php
     }
?>
</div>