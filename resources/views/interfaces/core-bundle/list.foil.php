<?php
/** @var Foil\Template\Template $t */
$this->layout( 'layouts/ixpv4' );
?>

<?php $this->section( 'title' ) ?>
    <a href="<?= action( 'Interfaces\CoreBundleController@list' )?>">Core Bundle</a>
<?php $this->append() ?>

<?php $this->section( 'page-header-postamble' ) ?>
    <li>List</li>
<?php $this->append() ?>

<?php $this->section( 'page-header-preamble' ) ?>
    <li class="pull-right">
        <div class=" btn-group btn-group-xs" role="group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="glyphicon glyphicon-plus"></i> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li>
                    <a href="<?= action( 'Interfaces\CoreBundleController@addWizard' )?>" >
                        Add Core Bundle Wizard...
                    </a>
                </li>
            </ul>
        </div>
    </li>
<?php $this->append() ?>

<?php $this->section('content') ?>

    <?= $t->alerts() ?>
    <span id="message-cb"></span>
    <div id="area-cb" class="collapse">
        <table id='table-cb' class="table">
            <thead>
            <tr>
                <th>
                    DB ID
                </th>
                <th>
                    Description
                </th>
                <th>
                    Type
                </th>
                <th>
                    Enabled
                </th>
                <th>
                    Switch A
                </th>
                <th>
                    Switch B
                </th>
                <th>
                    Capacity
                </th>
                <th>
                    Action
                </th>
            </tr>
            <thead>
            <tbody>
                <?php foreach( $t->cbs as $cb ):
                    /** @var \Entities\CoreBundle $cb */?>
                    <tr>
                        <td>
                            <?= $cb->getId() ?>
                        </td>
                        <td>
                            <?= $t->ee( $cb->getDescription() )  ?>
                        </td>
                        <td>
                            <?= $t->ee( $cb->resolveType() )  ?>
                        </td>
                        <td>
                            <?php if( !$cb->getEnabled() ):?>
                                <i class="glyphicon glyphicon-remove"></i>
                            <?php elseif( $cb->getEnabled() && $cb->doAllCoreLinksEnabled() ): ?>
                                <i class="glyphicon glyphicon-ok"></i>
                            <?php else:?>
                                <span class="label label-warning"><?= count( $cb->getCoreLinksEnabled() ) ?> / <?= count( $cb->getCoreLinks() )?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $t->ee( $cb->getSwitchSideX( true )->getName() )  ?>
                        </td>
                        <td>
                            <?= $t->ee( $cb->getSwitchSideX( false )->getName() )  ?>
                        </td>
                        <td>
                            <?= $t->scaleBits( count( $cb->getCoreLinks() ) * $cb->getSpeedPi() * 1000000, 0 )  ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn btn-default" href="<?= action( 'Interfaces\CoreBundleController@edit' , [ 'id' => $cb->getId() ] ) ?>" title="Edit">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
            <tbody>
        </table>
    </div>
<?php $this->append() ?>

<?php $this->section( 'scripts' ) ?>
    <script>
        $( document ).ready( function() {
            $( '#table-cb' ).DataTable( {
                "autoWidth": false,
                "iDisplayLength": 100,
                "columnDefs": [{
                    "targets": 2,
                    "type": "string" ,
                }]
            });

            $( "#area-cb" ).show();
        });
    </script>
<?php $this->append() ?>