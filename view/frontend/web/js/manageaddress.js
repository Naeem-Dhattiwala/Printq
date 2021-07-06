define([
    'jquery',
    'mage/url'
], function ($,url) {
    'use strict';
    var waitForE1 = function(selector, callback) {
        if ($(selector).length) {
           callback();
       } else {
          setTimeout(function() {
            waitForE1(selector, callback);
          }, 1000);
       }
    };
    waitForE1("select[name='custom_address_name']", function() {
        $("select[name='custom_address_name']").val('').change();
    });
    $( document.body ).click(function() {
        var id = $("select[name='custom_address_name']").val();
        if (id) {
            $("input[name='company']").prop('disabled', true);
            $("input[name='street[0]']").prop('disabled', true);
            $("input[name='street[1]']").prop('disabled', true);
            $("input[name='street[2]']").prop('disabled', true);
            $("input[name='city']").prop('disabled', true);
            $("select[name='country_id']").prop('disabled', true);
            $("select[name='region_id']").prop('disabled', true);
            $("input[name='postcode']").prop('disabled', true);
            $("input[name='vat_id']").prop('disabled', true);
        }
        else{
            $("input[name='company']").prop('disabled', false);
            $("input[name='street[0]']").prop('disabled', false);
            $("input[name='street[1]']").prop('disabled', false);
            $("input[name='street[2]']").prop('disabled', false);
            $("input[name='city']").prop('disabled', false);
            $("select[name='country_id']").prop('disabled', false);
            $("select[name='region_id']").prop('disabled', false);
            $("input[name='postcode']").prop('disabled', false);
            $("input[name='vat_id']").prop('disabled', false);
        }
    });
    $(document).on('click',"#next",function() {
        var id = $("select[name='custom_address_name']").val();
        if (id) {
            setTimeout(function(){
                $('body').trigger('click');
            }, 100);
        }
    });
    $(document).on('change',"[name='custom_address_name']",function(){
        if($('.edit-address-link:visible')[0]){
            $(".new-address-popup").remove();
        }
        var id = $("select[name='custom_address_name']").val();
        if(id){
            $('#shipping-save-in-address-book').attr('checked', false).change();
            $("#saveInAddressBook").hide();
            $.ajax({
                url: url.build('printq_customaddress'), 
                dataType: 'json',
                showLoader: true,
                method: 'POST',
                data: {
                    input_val : id
                },
                success: function(response) {
                    $("input[name='company']").val(response.company).change();
                    $("input[name='street[0]']").val(response.street).change();
                    $("input[name='city']").val(response.city).change();
                    $("select[name='country_id']").val(response.country_id).change();
                    $("select[name='region_id']").val(response.region_id).change();
                    $("input[name='postcode']").val(response.postcode).change();
                    $("input[name='vat_id']").val(response.vatid).change();
                    $("input[name='company']").prop('disabled', true);
                    $("input[name='street[0]']").prop('disabled', true);
                    $("input[name='street[1]']").prop('disabled', true);
                    $("input[name='street[2]']").prop('disabled', true);
                    $("input[name='city']").prop('disabled', true);
                    $("select[name='country_id']").prop('disabled', true);
                    $("select[name='region_id']").prop('disabled', true);
                    $("input[name='postcode']").prop('disabled', true);
                    $("input[name='vat_id']").prop('disabled', true);
                    console.log(response); 
                }
            });
        } else{
            $("#saveInAddressBook").show();
            $("input[name='company']").val('').change();
            $("input[name='street[0]']").val('').change();
            $("input[name='city']").val('').change();
            $("select[name='country_id']").val('').change();
            $("select[name='region_id']").val('').change();
            $("input[name='postcode']").val('').change();
            $("input[name='vat_id']").val('').change();
        }
    });
});