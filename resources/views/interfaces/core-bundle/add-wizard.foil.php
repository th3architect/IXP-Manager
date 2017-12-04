<?php
    /** @var Foil\Template\Template $t */
    $this->layout( 'layouts/ixpv4' );
?>



<?php $this->section( 'headers' ) ?>
    <style>
        /*.checkbox input[type=checkbox]{*/
            /*margin-left: 0px;*/
        /*}*/

        .col-lg-offset-2{
            margin-left: 0px;
        }

        /*.checkbox{*/
            /*text-align: center;*/
        /*}*/

        #table-core-link tr td{
            vertical-align: middle;
        }

        #btn-group-add div{
            text-align : center;
        }
    </style>
<?php $this->append() ?>



<?php $this->section( 'title' ) ?>
    <a href="<?= action( 'Interfaces\CoreBundleController@list' )?>">Core Bundles</a>
<?php $this->append() ?>



<?php $this->section( 'page-header-postamble' ) ?>
    <li>Add Core Bundle Wizard</li>
<?php $this->append() ?>



<?php $this->section( 'page-header-preamble' ) ?>
    <li class="pull-right">
        <div class="btn-group btn-group-xs" role="group">
            <a type="button" class="btn btn-default" href="<?= route( 'core-bundle/list' )?>" title="list">
                <span class="glyphicon glyphicon-th-list"></span>
            </a>
        </div>
    </li>
<?php $this->append() ?>



<?php $this->section('content') ?>

    <?= $t->alerts() ?>

    <?= Former::open()->method( 'post' )
        ->id( 'core-bundle-form' )
        ->action( route( 'core-bundle/store' ) )
        ->customWidthClass( 'col-sm-6' )
    ?>

    <div class="well col-sm-12">

        <div class="col-sm-6">

            <h3>
                General Settings:
            </h3>

            <hr>

            <?= Former::select( 'customer' )
                ->label( 'Customer' )
                ->fromQuery( $t->customers, 'name' )
                ->placeholder( 'Choose a customer...' )
                ->addClass( 'chzn-select' )
                ->blockHelp( 'Core bundles must be associated with an internal customer. An <em>internal</em> customer '
                    . 'is typically the customer representing the IXP. Sometimes there may be more than one - such as '
                    . 'a second internal customer for route servers.'
                );
            ?>

            <?= Former::text( 'description' )
                ->label( 'Description' )
                ->placeholder( 'Description' )
                ->blockHelp( 'A descriptive but short string to represent the core bundle link.<br><br>'
                    . 'An example might be <code>LAN1: cwt1-kcp1 (west ring 100G)</code> which shows the '
                    . 'infrastructure, the PoPs at each end and a further piece of information.'
                );
            ?>

            <?= Former::text( 'graph-title' )
                ->label( 'Graph Title' )
                ->placeholder( 'Graph Title' )
                ->blockHelp( 'Typically the same as the description above but this allows you the option of '
                    . 'further customising the title as shown on the graphs.'
                );
            ?>

            <?= Former::select( 'type' )
                ->label( 'Type' )
                ->fromQuery( $t->types, 'name' )
                ->placeholder( 'Core bundle type...' )
                ->addClass( 'chzn-select' )
                ->blockHelp( 'The kind of core bundle you are creating. See official documentation for more information.' )
                ->value( Entities\CoreBundle::TYPE_ECMP );
            ?>

            <div id="stp-div" style="display: none">
                <?= Former::checkbox( 'stp' )
                    ->id('stp')
                    ->label( '&nbsp;' )
                    ->text( '<b>Spanning tree enabled?</b>')
                    ->checked_value( 1 )
                    ->unchecked_value( 0 )
                    ->blockHelp( "" );
                ?>
            </div>

            <?= Former::number( 'cost' )
                ->label( 'Cost' )
                ->placeholder( '10' )
                ->min( 0 )
                ->blockHelp( 'The appropriate cost value for the core bundle type. See official documentation for more information.' );
            ?>


            <?= Former::number( 'preference' )
                ->label( 'Preference' )
                ->placeholder( '10' )
                ->min( 0 )
                ->blockHelp( 'The appropriate preference value for the core bundle type. See official documentation for more information.' );
            ?>


            <?= Former::checkbox( 'enabled' )
                ->id( 'enabled' )
                ->label('&nbsp;')
                ->text( '<b>Enabled</b>' )
                ->unchecked_value( 0 )
                ->blockHelp( "If set to disabled, all elements of this core bundle will be disabled." );
            ?>
        </div>


        <div class="col-sm-6">

            <h3>
                Virtual Interface Settings:
            </h3>

            <hr>

            <?= Former::checkbox( 'framing' )
                ->id( 'framing' )
                ->label('&nbsp;')
                ->text( '<b>Use 802.1q framing</b>' )
                ->unchecked_value( 0 )
                ->value( 1 )
                ->blockHelp( "Should 802.1q / VLAN tagging be enabled on this interface / interfaces?" );
            ?>

            <?= Former::number( 'mtu' )
                ->label( 'MTU' )
                ->value( 9000 )
                ->min( 0 )
                ->blockHelp( 'The MTU to set. Depending on your provisioning system / automation design, this should '
                    . 'apply appropriately to the L2 and/or the L3 MTU.' );
            ?>

            <div class="lag-area" style="display: none" >
                <?= Former::checkbox( 'fast-lacp' )
                    ->label('&nbsp')
                    ->text( '<b>Use Fast LACP</b>' )
                    ->unchecked_value( 0 )
                    ->value( 1 )
                    ->blockHelp( 'When LACP is used for LAG framing, indicates if operators / provisioning systems should enable fast LACP.' )
                ?>
            </div>

            <div id="l3-lag-area" style="display: none">

                <?= Former::checkbox( 'bfd' )
                    ->label('&nbsp;')
                    ->text( '<b>Use / enable BFD</b>' )
                    ->unchecked_value( 0 )
                    ->value( 1 )
                    ->blockHelp( 'Use BFD (Bidirectional Forwarding Detection) on this link.' )
                ?>

                <?= Former::text( 'subnet' )
                    ->label( 'Link Subnet' )
                    ->placeholder( '192.0.2.0/31 | 2001:db8::/127' )
                    ->blockHelp( 'The subnet over this link. Typically the <em>Switch A</em> side would be assigned '
                        . 'the first usable IP address and the <em>Switch B</em> side the second.' )
                ?>

            </div>

        </div>


        <div class="lag-area col-sm-12" style="display: none" >

            <div class="col-sm-6">

                <h4>Side A Virtual Interface Settings:</h4>

                <hr>

                <?= Former::text( 'vi-name-a' )
                    ->label( 'Virtual Interface Name' )
                    ->placeholder( 'Port-Channel' )
                    ->blockHelp( 'This is used to indicate the interface base name for LAGs where required. E.g. on a Cisco, this would be <code>Port-Channel</code>.' )
                ?>

                <?= Former::number( 'vi-channel-number-a' )
                    ->label( 'Channel Group Number' )
                    ->placeholder( '99' )
                    ->blockHelp( 'This is used to indicate the unique LAG number where required.' )
                    ->min( 0 );
                ?>
            </div>

            <div class="col-sm-6">

                <h4>Side B Virtual Interface Settings:</h4>

                <hr>

                <?= Former::text( 'vi-name-b' )
                    ->label( 'Virtual Interface Name' )
                    ->placeholder( 'Port-Channel' )
                    ->blockHelp( 'This is used to indicate the interface base name for LAGs where required. E.g. on a Cisco, this would be <code>Port-Channel</code>.' )
                ?>

                <?= Former::number( 'vi-channel-number-b' )
                    ->label( 'Channel Group Number' )
                    ->placeholder( '99' )
                    ->blockHelp( 'This is used to indicate the unique LAG number where required.' )
                    ->min( 0 );
                ?>
            </div>

        </div>

    </div>

    <br>

    <div style="clear: both"></div>


    <div class="well col-sm-12">

        <div class="col-sm-12">
            <h4>Common Link Settings:</h4>
            <hr>
        </div>


        <div class="col-sm-6">
            <?= Former::select( 'switch-a' )
                ->id( 'switch-a' )
                ->label( 'Switch A:' )
                ->fromQuery( $t->switches, 'name' )
                ->placeholder( 'Choose the A-side switch...' )
                ->addClass( 'chzn-select' )
                ->blockHelp('Select the switch where the A-side links terminate.')
            ?>
        </div>

        <div class="col-sm-6">
            <?= Former::select( 'switch-b' )
                ->id( 'switch-b' )
                ->label( 'Switch B:' )
                ->fromQuery( $t->switches, 'name' )
                ->placeholder( 'Choose the B-side switch...' )
                ->addClass( 'chzn-select' )
                ->blockHelp('Select the switch where the B-side links terminate.')
            ?>
        </div>

        <br>

        <div style="clear: both"></div>

        <br>

        <div class="col-sm-6">
            <?= Former::select( 'speed' )
                ->label( 'Speed:' )
                ->id( 'speed' )
                ->fromQuery( $t->speed, 'name' )
                ->placeholder( 'Choose the individual link speed...' )
                ->addClass( 'chzn-select' )
                ->blockHelp('Select the speed of each individual link in the core bundle.')
            ?>
        </div>

        <div class="col-sm-6">
            <?= Former::select( 'duplex' )
                ->id( 'duplex' )
                ->label( 'Duplex:' )
                ->fromQuery( $t->duplex, 'name' )
                ->placeholder( 'Choose the individual link duplex...' )
                ->select( 'full' )
                ->addClass( 'chzn-select' )
                ->blockHelp('Select the duplex of each individual link in a core bundle.')
            ?>
        </div>

        <br>

        <div style="clear: both"></div>

        <br>

        <div class="col-sm-6">
            <?= Former::checkbox( 'auto-neg' )
                ->label('&nbsp;')
                ->text( '<b>Auto-Negotiation enabled?</b>' )
                ->unchecked_value( 0 )
                ->value( 1 )
                ->check( true )
            ?>
        </div>

        <div style="clear: both"></div>

    </div>

    <div style="clear: both"></div>

    <div id="div-links" style="display: none">

        <h3>
            Core Links:

            <button style="float: right; margin-right: 20px" id="add-new-core-link" type="button" class=" btn-xs btn btn-default" href="#" title="Add Core link">
                <span class="glyphicon glyphicon-plus"></span>
            </button>

        </h3>

        <br>

        <div class="col-sm-12" id="core-links-area">

        </div>

    </div>

    <?= Former::hidden( 'nb-core-links' )
        ->id( 'nb-core-links')
        ->value( 0 )
    ?>

    <?= Former::actions(
            Former::primary_submit( 'Create Core Bundle' )->id( 'core-bundle-submit-btn' ),
            Former::default_link( 'Cancel' )->href( route( 'core-bundle/list' ) ),
            Former::success_button( 'Help' )->id( 'help-btn' )
        )->id('btn-group-add')
    ?>

    <?= Former::close() ?>


    <br><br><br>
<?php $this->append() ?>

<?php $this->section( 'scripts' ) ?>
    <script type="text/javascript" src="<?= asset( '/bower_components/ip-address/dist/ip-address-globals.js' ) ?>"></script>
    <?= $t->insert( 'interfaces/common/js/cb-functions' ); ?>
    <?= $t->insert( 'interfaces/core-bundle/js/add-wizard' ); ?>
<?php $this->append() ?>