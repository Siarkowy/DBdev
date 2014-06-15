<?php include 'view.Tabs.php' ?>
<?php if ($npc): ?>
<?php if ($npc->hasAI()): ?>
                <table class="table table-condensed table-striped events">
<?php foreach ($npc->ai->data as $e): ?>
                    <tr>
                        <th>
                            <sup><?= $e->id ?></sup> <?= $e->getFlagsString() ?> <?= $e->getType() ?> &bull;
                            <?= $e->event_chance ?>% <?= $e->event_inverse_phase_mask != 0 ? "phase ~{$e->event_inverse_phase_mask}" : '' ?>
                        </th>
                        <th class="text-right">
                            <?= $e->getParams() ?>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <p class="pull-right"><a href="?page=event&action=edit&id=<?= $e->id ?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a></p>
                            <?= $e->comment != '' ? "<p>{$e->comment}</p>\n" : '' ?><?= $e->getActions() ?>
                        </td>
                    </tr>
<?php endforeach // ai data ?>
                </table>
<?php else: ?>
                <div class="alert alert-info">No EventAI scripts present.</div>
<?php endif // hasAI ?>
                <p><a href="?page=event&action=add&npc=<?= $npc->entry ?>" class="btn btn-primary" accesskey="a"><span class="glyphicon glyphicon-plus"></span> Add script</a></p>
<?php if ($npc->ScriptName): ?>
                <div class="alert alert-info">This is a C++ scripted creature under <strong><?= $npc->ScriptName ?></strong>.</div>
<?php endif // scriptname ?>
<?php elseif (@$request['id']): ?>
                <div class="alert alert-warning">NPC not found.</div>
<?php else: ?>
                <div class="alert alert-info">Enter query into search box on the right.</div>
<?php endif // npc ?>
