                <div class="pull-right">
                    <form action="?" method="get" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only">Query string</label>
                            <input class="form-control" type="text" name="id" id="id" value="<?= @$request['id'] ?>" accesskey="q" placeholder="Query">
                            <input type="hidden" name="page" value="<?= @$request['page'] ?>">
                        </div>

                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </form>
                </div>
                <ul class="nav nav-tabs">
                    <li class="<?= $view == 'Creature' ? 'active' : '' ?>">
                        <a href="?page=scripts&amp;id=<?= (int) @$request['id'] ?>" accesskey="s">Scripts</a>
                    </li>
                    <li class="<?= $view == 'Loot' ? 'active' : '' ?>">
                        <a href="?page=loot&amp;id=<?= (int) @$request['id'] ?>" accesskey="l">Loot</a>
                    </li>
                </ul>
