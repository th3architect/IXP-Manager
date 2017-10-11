<?php

    // MRTG Configuration Templates
    //
    // You should not need to edit these files - instead use your own custom skins. If
    // you can't effect the changes you need with skinning, consider posting to the mailing
    // list to see if it can be achieved / incorporated.

?>


# kcp1-cwt1 - LAN1 - Secondary
Target[core-kcp1-cwt1-lan1-sec]: #Ethernet25:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet26:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet27:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet28:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet29:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet30:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet31:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
    + #Ethernet32:<?=config('custom.grapher.snmp_password','xxxxxx')?>@swi1-kcp1-2.mgmt.inex.ie:::::2
MaxBytes[core-kcp1-cwt1-lan1-sec]: 10000000000
Directory[core-kcp1-cwt1-lan1-sec]: trunks
Title[core-kcp1-cwt1-lan1-sec]: Trunk Core - KCP1 - CWT1 - LAN1 - Secondary




