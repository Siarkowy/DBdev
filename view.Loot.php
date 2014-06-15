<?php include 'view.Tabs.php' ?>
<?php if ($npc): ?>
<?php if ($npc->loot && !empty($npc->loot->data)): ?>
                <div class="loot">
<?= $npc->loot ?>
                </div>
<?php else: ?>
                <div class="alert alert-info">Creature has no loot.</div>
<?php endif // loot ?>
<?php elseif (@$request['id']): ?>
                <div class="alert alert-warning">NPC not found.</div>
<?php else: ?>
                <div class="alert alert-info">Enter query into search box on the right.</div>
<?php endif // npc ?>
