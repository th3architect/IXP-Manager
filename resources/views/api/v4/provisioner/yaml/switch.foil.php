interfacescust:

<?php foreach( $t->ports as $p ): ?>
  - name: <?= $p['name'] ?>

    type: <?= $p['type'] ?>

    description: "<?= $p['description'] ?>"
    dot1q: <?= $p['dot1q'] ?>

<?php if( isset( $p['shutdown']  ) ){ ?>    shutdown: <?= $p['shutdown']   . "\n" ?><?php } ?>
<?php if( isset( $p['stp']       ) ){ ?>    stp: <?= $p['stp']     . "\n" ?><?php } ?>
<?php if( isset( $p['autoneg']   ) ){ ?>    autoneg: <?= $p['autoneg']     . "\n" ?><?php } ?>
<?php if( isset( $p['speed']     ) ){ ?>    speed: <?= $p['speed']         . "\n" ?><?php } ?>
<?php if( isset( $p['lagindex']  ) ){ ?>    lagindex: <?= $p['lagindex']   . "\n" ?><?php } ?>
<?php if( isset( $p['lagmaster'] ) ){ ?>    lagmaster: <?= $p['lagmaster'] . "\n" ?><?php } ?>
<?php if( isset( $p['lagmembers'] ) ){ ?>
    lagmembers:
<?php foreach( $p['lagmembers'] as $lagmember ): ?>
          - "<?= $lagmember ?>"
<?php endforeach; ?>
<?php } ?>
<?php if( isset( $p['fastlacp']  ) ){ ?>    fastlacp: <?= $p['fastlacp']   . "\n" ?><?php } ?>
    virtualinterfaceid: <?= $p['virtualinterfaceid'] ?>

    vlans:
<?php foreach( $p['vlans'] as $vlan ): ?>
      - number: <?= $vlan['number'] ?>

<?php if( count( $vlan['macaddresses']  ) ): ?>
        macaddress:
<?php foreach( $vlan['macaddresses'] as $mac ): ?>
          - "<?= $mac ?>"
<?php endforeach; ?>
<?php endif; ?>
<?php endforeach; ?>

<?php endforeach; ?>

