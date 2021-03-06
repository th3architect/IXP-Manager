<?php
    /** @var Foil\Template\Template $t */
    $this->layout( 'layouts/ixpv4' )
?>

<?php $this->section( 'title' ) ?>
    <h3>
        MAC Address Management

        <span class="pull-right" id="span-cust-add-btn" style="<?= count( $t->vli->getLayer2Addresses() ) >= config( 'ixp_fe.layer2-addresses.customer_params.max_addresses' ) ? 'display: none;' : '' ?>">
            <div class="btn-group btn-group-sm" id="add-btn" role="group">
                <a type="button" class="btn btn-default" id="add-l2a">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </span>
    </h3>
<?php $this->append() ?>


<?php $this->section( 'content' ) ?>

    <?= $t->alerts() ?>

    <?php if( config( 'ixp_fe.layer2-addresses.customer_can_edit') ): ?>
        <?= $t->insert( 'layer2-address/customer-edit-msg.foil.php' ) ?>
    <?php endif; ?>


    <div id="message"></div>
    <div id="list-area" class="collapse">
        <table id='layer-2-interface-list' class="table">
            <thead>
            <tr>
                <td>ID</td>
                <td>MAC Address</td>
                <td>Created At</td>
                <td>Action</td>
            </tr>
            <thead>
            <tbody >
            <?php foreach( $t->vli->getLayer2Addresses() as $l2a ):
                /** @var \Entities\Layer2Address $l2a */
                ?>
                <tr>
                    <td>
                        <?= $l2a->getId() ?>
                    </td>
                    <td>
                        <?= $l2a->getMacFormattedWithColons() ?>
                    </td>
                    <td>
                        <?= $l2a->getCreatedAt()->format('Y-m-d') ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a class="btn btn btn-default" id="view-l2a-<?= $l2a->getId() ?>" name="<?= $l2a->getMac() ?>" href="#" title="View">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <?php if( count( $t->vli->getLayer2Addresses() ) > config( 'ixp_fe.layer2-addresses.customer_params.min_addresses' ) ): ?>
                                <button class="btn btn btn-default" id="delete-l2a-<?= $l2a->getId() ?>" href="#" title="Delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
            <tbody>
        </table>
    </div>

    <?= $t->insert( 'layer2-address/modal-mac' ); ?>

<?php $this->append() ?>

<?php $this->section( 'scripts' ) ?>
<?= $t->insert( 'layer2-address/js/clipboard' ); ?>
<?= $t->insert( 'layer2-address/js/vlan-interface' ); ?>
<?php $this->append() ?>

