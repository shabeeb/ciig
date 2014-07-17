 
                 
                 
    <script type="text/javascript">
      var base_url = '';
        $(document).ready(function() {

        $("#dataTable").dataTable({
            "aaSorting": [[0, "asc"]],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "pdt_member/list_all_data",
            "aoColumns": [ 
                    {"sTitle": "member id", "mData": "member_id"}, 
                    {"sTitle": "ig id", "mData": "ig_id"}, 
                    {"sTitle": "card number", "mData": "card_number"}, 
                    {"sTitle": "first name", "mData": "first_name"}, 
                    {"sTitle": "last name", "mData": "last_name"},    
                {"sTitle": "Action", "sClass": "center", "mData": null,
                    "bSortable": false,
                    "mRender": function(data, type, full)
                    {
                        var edit = '<td><a href="' +  + 'pdt_member/edit/' + full.member_id+'" class="edit"><i class="icon-edit"></i></a>' +
                                '  <a href="' +  + 'pdt_member/remove_form" id="' + full.member_id + '" data-id ="' + full.member_id + '" class="delete-confirm" ><i class="icon-delete"></i></a>'                           
                                                           
                                + '</td>'
                            ;
                        return edit;
                    }},
                ],
         });

        });
    </script>

<?php //if ($this->session->flashdata('smessage')) { ?>
    <div id="smessage" class="secondary alert"><?php //echo $this->session->flashdata('smessage'); ?></div>
<?php ///} else { ?>
    <div id="smessage"></div>
<?php //} ?>            



 <h3 class="text-muted">pdt_member Listing </h3>
   
            
                 <a href="<?php //  echo site_url('pdt_member/create') ?>pdt_member/create" class="rt-but">Create pdt_member</a>
   

<div class="row marketing">
        <div class="col-lg-12">
 <div id="datatable-wrapper">
                <table id="dataTable" cellpadding="0" cellspacing="0" border="0" class="display" >
                </table>
            </div> 
        </div>
    </div>
        