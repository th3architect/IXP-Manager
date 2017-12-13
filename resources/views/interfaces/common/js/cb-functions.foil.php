<script>

let excludedSwitchPortSideA  = [];
let excludedSwitchPortSideB  = [];

/**
 * Insert in an array all the switch ports selected from all the switch port dropdowns
 * in order the exclude them from the new switch port dropdowns that could be added
 */
function excludedSwitchPort( sside ){

    $( "[id|='sp-" +sside+ "'] :selected" ).each( function() {
        if( this.value.trim() !== '' ) {
            if( sside === 'a' ) {
                if( excludedSwitchPortSideA.indexOf( this.value ) === -1 ){
                    excludedSwitchPortSideA.push( this.value );
                }
            } else {
                if( excludedSwitchPortSideB.indexOf( this.value ) === -1 ) {
                    excludedSwitchPortSideB.push(this.value);
                }
            }
        }
    });
}


/**
 * set data to the switch port dropdown when we select a switcher
 */
function setSwitchPort( sside, id, action, edit ) {
    let postData;
    let switchId = $( "#switch-" + sside ).val();

    if( $("#nb-core-links").val() > 0 || edit ) {

        $( "#sp-" + sside + "-"+ id ).html( `<option value="">Loading, please wait...</option>\n` ).trigger( 'change.select2' );

        if( !edit ) {
            excludedSwitchPort( sside );
        }

        if( switchId !== null && switchId.trim() !== '' ) {
            let url = "<?= url( '/api/v4/switch' )?>/" + switchId + "/switch-port";

            if( !edit ) {
                postData = {
                    spIdsExcluded: excludedSwitchPortSideA.concat( excludedSwitchPortSideB )
                };
            } else {
                postData = {
                    spIdsExcluded: []
                };
            }

            $.ajax( url , {
                    data: postData,
                    type: 'POST'
                })
                .done( function( data ) {
                    let options = `<option value="">Choose a switch port...</option>\n`;

                    $.each( data.listPorts, function( key, value ) {
                        options += `<option value="${value.id}">${value.name} (${value.type})</option>\n`;
                    });

                    $( "#sp-" + sside + "-" + id ).html( options );

                    if( action === 'addBtn' ) {
                        selectNextSwitchPort( id, sside );
                    }
                })
                .fail( function() {
                    alert( `Error running ajax query for ${url}` );
                    throw new Error( `Error running ajax query for ${url}` );
                })
                .always( function() {
                    $( "#sp-" + sside + "-"+ id ).trigger('change.select2');
                });
        }
    }
}

/**
 * Select the next sequential switch port depending of the previous core links
 */
function selectNextSwitchPort( id, side ) {

    let dropdownId       = "#sp-" + side + "-" + id;
    let lastdropdownId   = "#sp-" + side + "-" + (id - 1);

    let nextSwitchPortId = $( lastdropdownId + " option:selected" ).next().val();


    if( undefined !==  $( dropdownId + " option[value='" + nextSwitchPortId + "']" ) && $( dropdownId + " option[value='" + nextSwitchPortId + "']" ).length  ) {
        $( dropdownId ).val( nextSwitchPortId ).trigger('change.select2');
    }

    $( "#hidden-sp-"+ side + '-' + id ).val( $( dropdownId ).val() );
}

/**
 * check if the subnet is valid and display a message
 */
function checkSubnet( subnet ) {

    let e = $( "#"+subnet );

    e.parent().parent().removeClass( 'has-error' );
    e.parent().find('span').remove();

    if( e.val().trim() !== '' && !validSubnet( e.val() ) ) {
        e.parent().parent().addClass( 'has-error' );
        e.parent().append( "<span class='help-block' style='display: block'>The subnet is not valid</span>" );
    }
}

/**
 * Check if the subnet provided is valid
 */
function validSubnet( subnet ) {

    let address;

    if( subnet.indexOf( ':' ) === -1 ) {
        address = new Address4(subnet);
    } else {
        address = new Address6(subnet);
    }

    return address.isValid();
}

</script>