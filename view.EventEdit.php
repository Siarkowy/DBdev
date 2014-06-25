                <form action="?page=event&amp;action=save" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="e[type]" class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="e[type]">
<?php foreach (Event::$events as $id => $data): if ($id >= 0): ?>
                                <option value="<?= $id ?>"<?= $id == @$e->event_type ? ' selected="selected"' : '' ?>><?= $data[0] ?></option>
<?php endif; endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[par1]" class="col-sm-2 control-label">Params</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[par1]" placeholder="Param 1" value="<?= @$e->event_param1 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[par2]" placeholder="Param 2" value="<?= @$e->event_param2 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[par3]" placeholder="Param 3" value="<?= @$e->event_param3 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[par4]" placeholder="Param 4" value="<?= @$e->event_param4 ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[invphase]" class="col-sm-2 control-label">~Phase</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="e[invphase]" placeholder="~Phase" value="<?= @$e->event_inverse_phase_mask ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[chance]" class="col-sm-2 control-label">Chance</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="e[chance]" placeholder="Chance" value="<?= @$e->event_chance ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[chance]" class="col-sm-2 control-label">Flags</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="e[flags][]" multiple="multiple" size="8">
<?php foreach (Event::$flags as $flag => $name): ?>
                                <option value="<?= $flag ?>"<?= @$e->event_flags & $flag ? ' selected="selected"' : '' ?>><?= $name ?></option>
<?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[a1_type]" class="col-sm-2 control-label">Action 1</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-xs-3">
                                    <select class="form-control" name="e[a1_type]">
<?php foreach (Event::$actions as $id => $data): ?>
                                        <option value="<?= $id ?>"<?= $id == @$e->action1_type ? ' selected="selected"' : '' ?>><?= $data[0] ?></option>
<?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a1_par1]" placeholder="Param 1" value="<?= @$e->action1_param1 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a1_par2]" placeholder="Param 2" value="<?= @$e->action1_param2 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a1_par3]" placeholder="Param 3" value="<?= @$e->action1_param3 ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[a2_type]" class="col-sm-2 control-label">Action 2</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-xs-3">
                                    <select class="form-control" name="e[a2_type]">
<?php foreach (Event::$actions as $id => $data): ?>
                                        <option value="<?= $id ?>"<?= $id == @$e->action2_type ? ' selected="selected"' : '' ?>><?= $data[0] ?></option>
<?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a2_par1]" placeholder="Param 1" value="<?= @$e->action2_param1 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a2_par2]" placeholder="Param 2" value="<?= @$e->action2_param2 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a2_par3]" placeholder="Param 3" value="<?= @$e->action2_param3 ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e[a3_type]" class="col-sm-2 control-label">Action 3</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-xs-3">
                                    <select class="form-control" name="e[a3_type]">
<?php foreach (Event::$actions as $id => $data): ?>
                                        <option value="<?= $id ?>"<?= $id == @$e->action3_type ? ' selected="selected"' : '' ?>><?= $data[0] ?></option>
<?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a3_par1]" placeholder="Param 1" value="<?= @$e->action3_param1 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a3_par2]" placeholder="Param 2" value="<?= @$e->action3_param2 ?>"></div>
                                <div class="col-xs-3"><input type="text" class="form-control" name="e[a3_par3]" placeholder="Param 3" value="<?= @$e->action3_param3 ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="e[comment]" placeholder="Comment"><?= @$e->comment ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" accesskey="s"><span class="glyphicon glyphicon-ok"></span> Save</button>
                            <button type="reset" class="btn btn-default" accesskey="r">Reset</button>
                        </div>
                    </div>
                    <input type="hidden" name="e[id]" value="<?= @$e->id ?>">
                    <input type="hidden" name="e[guid]" value="<?= @$e->entryOrGUID ?>">
                </form>
