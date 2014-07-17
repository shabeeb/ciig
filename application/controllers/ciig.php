<?php

class ciig extends CI_Controller {

    private $tname; //table name
    private $controllername; // controller name
    private $fname; // form name
    private $form_title; // form tite
    private $modelname;
    private $listviewname;
    private $create_viewname;
    private $tbl_pk;
    private $first_min_no = 5;
    private $style_col = 4;
    private $auther = "Shabeeb";
    private $auther_mail = "me@shabeebk.com";
    private $created_date;
    private $header = 'header';
    private $footer = 'footer';

    public function __construct() {

        parent::__construct();

        $this->load->library('form_validation');
        $this->load->database();
        $this->load->library('zip');
        //$this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->created_date = date('Y-m-d ');
    }

    /**
     * Functon index
     * 
     * load the form and process
     * 
     * @auther shabeeb <me@shabeebk.com>
     * @createdon  17-06-2014
     * @
     * 
     * @param type 
     * @return type
     * exceptions
     * 
     */
    public function index() {

        $data = '';


        $this->form_validation->set_rules('tname', 'Table Name', 'required|xss_clean');
        $this->form_validation->set_rules('cname', 'Controller Name', 'required|xss_clean');
        $this->form_validation->set_rules('fname', 'Title Name', 'required|xss_clean');
        $this->form_validation->set_rules('tname', 'Table Name', 'required|xss_clean');
        if ($this->form_validation->run() === FALSE) {
            
        } else {

            $this->tname = $this->input->post("tname");
            $cname = $this->input->post("cname");
            $this->controllername = str_replace(' ', '_', $cname);
            $this->fname = $this->input->post("fname");
            $this->modelname = $this->controllername . '_model';
            $this->listviewname = 'list_' . $this->controllername;
            $this->create_viewname = 'create_' . $this->controllername;



            $fields = $this->db->field_data($this->tname);

            if (empty($fields)) {

                die("table not existing");
            }

            foreach ($fields as $field) {
                $field_name = $field->name;

                if ($field->primary_key == 1) {
                    $this->tbl_pk = $field_name;
                }
            }




            $controller = $this->build_controller($fields);
            $view_create = $this->build_view_create($fields);
            $model = $this->build_model($fields);
            $view_list = $this->build_view_listing($fields);
            $view_header = $this->build_header($fields);
            $view_footer = $this->build_footer($fields);

            $data['model'] = $model;
            $data['controller'] = $controller;
            $data['view_create'] = $view_create;
            $data['view_list'] = $view_list;
            $data['view_header'] = $view_header;
            $data['view_footer'] = $view_footer;
            
            //name for each file
            $data['controllername'] = $this->controllername;
            $data['modelname'] = $this->modelname;
            $data['listviewname'] = $this->listviewname;
            $data['create_viewname'] = $this->create_viewname;
            $data['header'] = $this->header;
            $data['footer'] = $this->footer;
        }






        $this->load->view('ciig', $data);
    }

    /**
     * Functon buld controller
     * 
     * it will bult structure of controller
     * 
     * @auther shabeeb <me@shabeebk.com>
     * @createdon  17-06-2014
     * @
     * 
     * @param type 
     * @return type 
     * exceptions controller name empty
     * 
     */
    function build_controller($fields = NULL) {

        if ($fields == NULL) {
            return FALSE;
        }

        $controller = '<?php
        class ' . ucfirst($this->controllername) . ' extends CI_Controller {

        public function __construct() {
                parent::__construct();
                $this->load->model(\'' . $this->modelname . '\');
            
        }



     /**
     * Functon index
     * 
     * list all the values in grid
     * 
     * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
     * @createdon   : ' . $this->created_date . '
     * 
     * 
     * @param type 
     * @return type
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
     
    function index(){


        $this->load->view(\'' . $this->header . '\');
        $this->load->view(\'' . $this->listviewname . '\');
        $this->load->view(\'' . $this->footer . '\');
    }';



        $controller .= ' 
       

     /**
     * Functon create
     * 
     * create form
     * 
     * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
     * @createdon   : ' . $this->created_date . '
     * @
     * 
     * @param type 
     * @return type
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */

    public function create() {			
            $data[\'id\']= 0;
           
            $this->load->view(\'' . $this->header . '\');
           $this->load->view(\'' . $this->create_viewname . '\',$data);
           $this->load->view(\'' . $this->footer . '\');

   }
    ';
        $controller .= ' 
       

 /**
     * Functon edit
     * edit form
     * 
     * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
     * @createdon   : ' . $this->created_date . '
     *
     * @param type 
     * @return type
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
         public function edit($id=0) {
		
		
                 $data[\'id\']= $id;
		if($id!=0){
			$result =  $this->' . $this->modelname . '->findByPk($id);
			if(empty($result))
				show_error(\'Page is not existing\', 404);
			else
				
                                  $data[\'update_data\']= $result;
		}
                

           $this->load->view(\'' . $this->header . '\');
           $this->load->view(\'' . $this->create_viewname . '\',$data);
           $this->load->view(\'' . $this->footer . '\');
				
	}
    ';

        $controller .= '
              
 /**
     * Functon process
     * 
     * process form
     * 
     * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
     * @createdon   : ' . $this->created_date . '
     * @
     * 
     * @param type 
     * @return type
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
      public function process_form(){
			
		if (!$this->input->is_ajax_request()) {
			exit(\'No direct script access allowed\');
		}
                
		$id = isset($_POST[\'id\']) ? $_POST[\'id\'] : 0;
		$userid = $this->session->userdata(\'user_id\');
		$message[\'is_error\'] =true;
		$message[\'error_count\'] =0;
		$data = array();
                
                   ';
        foreach ($fields as $field) {


            $field_name = $field->name;
            $pk = $field->primary_key;

            $label = str_replace('_', ' ', $field_name);

            if ($pk != 1) {
                $controller .= ' 
                        $this->form_validation->set_rules("' . $field_name . '", "' . $label . '", "required|xss_clean");';
            }
        }

        $controller .= '
            
            if ($this->form_validation->run() == FALSE){  
            
               $message[\'is_redirect\'] =false;
                $err =  validation_errors();
                //$err =  $this->form_validation->_error_array();
                $data[] = $err;
                $count = count($this->form_validation->error_array());
                $message[\'error_count\'] =$count;
          }else{ ';
        $controller .= '  $id = $this->input->post(\'id\');';
        foreach ($fields as $field) {
            $field_name = $field->name;
            $pk = $field->primary_key;
            if ($pk != 1) {


                $controller .= '$' . $field_name . '= $this->input->post(\'' . $field_name . '\');
                    ';
            }
        }



        $controller .= ' $data_inser_array = array( ';


        foreach ($fields as $field) {
            $field_name = $field->name;
            $pk = $field->primary_key;
            if ($pk != 1) {
                $controller .= ' \'' . $field_name . '\'=>$' . $field_name . ',
                        ';
            }
        }





        $controller .= ' );  
            
        if(isset($id) && !empty($id)){

            $condition = array("' . $this->tbl_pk . '"=>$id);
            $insert = $this->' . $this->modelname . '->update(\'' . $this->tname . '\',$data_inser_array,$condition);
            $data[] = "Data Updated Successfully.";
            $this->session->set_flashdata(\'smessage\',"Data Updated Successfully");
            $message[\'is_redirect\'] =true;
          }else{
            $insert = $this->' . $this->modelname . '->create(\'' . $this->tname . '\',$data_inser_array);
            $message[\'is_redirect\'] =true;

            $data[] = "Data Inserted Successfully.";
          }
          if($insert){
          
            $message[\'is_error\'] =false;
            $message[\'is_redirect\'] =true;

          }else{
            $message[\'is_error\'] =true;
            $message[\'is_redirect\'] =false;
            $data[] = "Something Went Wrong..";
          }

          }
          $message[\'data\'] =$data;
          echo json_encode($message);
          exit;
          
                
                
                
                ';



        $controller .= '  }';

        $controller .= '  

        /**
            * Functon list_all_data
            * 
            * process grid data 
            * 
            * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
            * @createdon   : ' . $this->created_date . '
            * @
            * 
            * @param type 
            * @return type
            * exceptions
            *
            * Created Usigng CIIgnator 
            * 
            */


            public function list_all_data() {
			
		if (!$this->input->is_ajax_request()) {
			exit(\'No direct script access allowed\');
		}
		
                
          
		$this->load->library(\'pagination\');
			
		$sort_col = $_GET["iSortCol_0"];
		$sort_dir = $_GET["sSortDir_0"];
		$limit = $_GET["iDisplayLength"];
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
		$config["total_rows"] = $this->' . $this->modelname . '->count_all_rows($search);
		

		$this->pagination->initialize($config);

		$data["links"] = $this->pagination->create_links();

			
		$sort_col = $_GET["iSortCol_0"];
		$sort_dir = $_GET["sSortDir_0"];
		$limit = $_GET["iDisplayLength"];
		$start =  $_GET["iDisplayStart"];
		$search =   $_GET["sSearch"];
			
			
		$arr = $this->' . $this->modelname . '->get_data($sort_col,$sort_dir,$limit,$start,$search);

		$output = array(
				"aaData" => $arr,
				"sEcho" => intval($_GET["sEcho"]),
				"iTotalRecords" => $config["total_rows"],
				"iTotalDisplayRecords" => $config["total_rows"],

		);
		echo json_encode($output);
			
		exit; 
	}';



        $controller .= '  }';

        return $controller;
    }

    function build_view_create($fields = NULL) {

        if ($fields == NULL) {
            return FALSE;
        }

        $view = ' <?php ';


        foreach ($fields as $field) {
            $field_name = $field->name;
            $view .= '
                    $' . $field_name . '= isset($update_data["' . $field_name . '"]) ? $update_data["' . $field_name . '"] : "";';
        }
        $view .= '

$btn_msg = ($id == 0) ? "ADD" : " Update";
$title_msg = ($id == 0) ? "Create" : " Update";
?>


<script type="text/javascript" >
    $(document).ready(function() {

        $(\'#' . $this->controllername . '\').validationEngine(\'attach\', {scroll: false, addFailureCssClassToField: \'inputbox-error\'});
    });
</script>


<div class="row">
<div class="col-lg-12">


             <h3 class="text-muted"><?php echo $title_msg; ?> ' . ucfirst($this->fname) . '</h3> 
                


                                <div id="smessage">
                                    <?php echo validation_errors();
                                           echo $this->session->flashdata(\'smessage\');
                                    ?>

                                </div>



                                <form action="" method="post"  class="form-group"  name="' . $this->controllername . '" id="' . $this->controllername . '">
                                    <?php
                                    if ($id != 0) {
                                        echo \'<input name="id" id="id" type="hidden" value="\' . $id . \'" />\';
                                    }
                                    ?>';
        $p = 0;

        foreach ($fields as $field) {


            $field_name = $field->name;


            $pk = $field->primary_key;
            if ($pk != 1) {




                $label = str_replace('_', ' ', $field_name);

               

                $view .= '   <div class="col-lg-'.$this->style_col.'">  
                                    <label>' . ucfirst($label) . '*</label>
                                    <div class="field">

                                        <input name="' . $field_name . '" id="' . $field_name . '" type="text"  class="xxwide text input validate[required] form-control" placeholder="' . ucfirst($label) . '" value="<?php echo $' . $field_name . '; ?>" />

 
                                    </div>
                             </div>';


               
            }
        }

        $view .= '   
                                          
                                            
                                            
                                            
                                             <div class="medium primary btn fright">
                                        <input name="insured_group"
                                               id="add_insuere_group" class="" value="<?php echo $btn_msg ?>" type="submit" />
                                    </div>
                                            
                                    

                                   
                                </form>




    </div>
</div>';


        $view .= '  <script>


    function save_data(e) {
        e.stopPropagation();
        e.preventDefault();
        var thisdata = $(e.target);

        var valid = jQuery(\'#' . $this->controllername . '\').validationEngine(\'validate\');
        

        if (valid == false) {
            return false;

        }
        $.ajax({
            type: "post",
            url: base_url + "' . $this->controllername . '/process_form",
            cache: false,
            data: $(\'#' . $this->controllername . '\').serialize(),
            success: function(json) {
                var obj = jQuery.parseJSON(json);
                var status = obj[\'is_error\'];
                var is_redirect = obj[\'is_redirect\'];
                var error_count = obj[\'error_count\'];

                if (status == false) {

            		
                    $(\'form input:text,form textarea\').val(\'\');

                    $(\'#smessage\').html(obj[\'data\']);
                    $(\'#smessage\').addClass("secondary").removeClass(\'danger\');
                    $(\'#smessage\').show();
                    if (is_redirect == true) {
                        window.location = base_url + \'' . $this->controllername . '\';
                    }
                } else {
                    if (is_redirect == true) {
                        window.location = base_url + \'' . $this->controllername . '\';
                    }
                    if (error_count != 0) {
                        $("#smessage").html("There are " + error_count + "  errors.please fix all");
                    } else {
                        $("#smessage").html("");
                    }
                    $("#smessage").append(obj["data"]);
                    $("#smessage").addClass("danger").removeClass("secondary");
                    $("#smessage").show();
                }
            },
            error: function() {
                alert("Something Went wrong...");
            }
        });


    }


    $(document).ready(function() {
        $("#smessage").hide();
        $(\'#' . $this->controllername . '\').submit(save_data);
      


    });


</script>


';


        return $view;
    }

    function build_view_listing($fields = NULL) {

        $view_list = ' 
                 
                 
    <script type="text/javascript">
        var base_url = "";//mention your base url here
        $(document).ready(function() {

        $("#dataTable").dataTable({
            "aaSorting": [[0, "asc"]],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": base_url + "' . $this->controllername . '/list_all_data",
            "aoColumns": [';
        $i = 0;
        foreach ($fields as $field) {
            $field_name = $field->name;
            $pk = $field->primary_key;
            $label = str_replace('_', ' ', $field_name);

            if ($i < $this->first_min_no) {//only defined colums will come
                $view_list .=' 
                    {"sTitle": "' . $label . '", "mData": "' . $field_name . '"},';
            }

            $i++;
        }



        $view_list .='    
                {"sTitle": "Action", "sClass": "center", "mData": null,
                    "bSortable": false,
                    "mRender": function(data, type, full)
                    {
                        var edit = \'<td><a href="\' + base_url + \'' . $this->controllername . '/edit/\' + full.' . $this->tbl_pk . '+\'" class="edit"><i class="icon-edit"></i></a>\' +
                                \'  <a href="\' + base_url + \'' . $this->controllername . '/remove_form" id="\' + full.' . $this->tbl_pk . ' + \'" data-id ="\' + full.' . $this->tbl_pk . ' + \'" class="delete-confirm" ><i class="icon-delete"></i></a>\'                           
                                                           
                                + \'</td>\'
                            ;
                        return edit;
                    }},
                ],
         });

        });
    </script>
';
        $view_list .= '
<?php if ($this->session->flashdata(\'smessage\')) { ?>
    <div id="smessage" class="secondary alert"><?php echo $this->session->flashdata(\'smessage\'); ?></div>
<?php } else { ?>
    <div id="smessage"></div>
<?php } ?>            



 <h3 class="text-muted">' . $this->fname . ' Listing </h3>
   
            
                 <a href="<?php echo site_url(\'' . $this->controllername . '/create\') ?>" class="rt-but">Create ' . $this->fname . '</a>
   

<div class="row marketing">
        <div class="col-lg-12">
 <div id="datatable-wrapper">
                <table id="dataTable" cellpadding="0" cellspacing="0" border="0" class="display" >
                </table>
            </div> 
        </div>
    </div>
        ';

        return $view_list;
    }

    function build_model($fields = NULL) {


        if ($fields == NULL) {
            return FALSE;
        }

        $model = ' <?php ';
        $model .= '

if (!defined("BASEPATH"))
    exit(\'No direct script access allowed\');

class ' . ucfirst($this->modelname) . ' extends SYS_Model { 
                
                
                
    /**
     * @var string
     * CMS Master table name
     */
    private $_table =\'' . $this->tname . '\';
    private $_pk_field = \'' . $this->tbl_pk . '\';
     ';

        $lis_col = '';
        $sort_col = '';
        $i = 0;
        foreach ($fields as $field) {

            $field_name = $field->name;

            $lis_col .= '\'' . $field_name . '\',';
            if ($i < $this->first_min_no) {//onlyt 5 coloums take now
                $sort_col .= '\'' . $field_name . '\',';
            }
            $i ++;
        }

        $model .= '  private $list_colums = array(' . $lis_col . ');
        private $sort_colums_order = array( ' . $sort_col . ' );
             



 public function __construct() {
    	
        parent::__construct();
        $this->load->database();
      
    }
    

';

        $model .= '
    

/**
     * Functon find by primery key
     * 
     * process  
     * 
     * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
     * @createdon   : ' . $this->created_date . '
     * @
     * 
     * @param type  id
     * @return type array
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
     

        function findByPk($id){
    	
            $this->db->select("*");
            $this->db->from($this->_table );

            $this->db->where($this->_pk_field,$id);
            $this->db->limit(1);
            $query = $this->db->get(); 
            $result = array_shift($query->result_array());

            return $result;
    	
    	
        }';



        $model .= '
    
/**
     * Functon get_data
     * 
     * process for search result
     * 
     * @auther ' . $this->auther . ' <' . $this->auther_mail . '>
     * @createdon   : ' . $this->created_date . '
     * @
     * 
     * @param type 
     * @return type
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
     
        public function get_data($sort_num=0,$sortby="DESC",$limit,$start,$search=""){
 		
 	$sort_field = $this->sort_colums_order[$sort_num];
 	$this->db->select($this->sort_colums_order);
 	$this->db->from($this->_table);
 	
 	$where = "is_active = 1";
 	if(!empty($search)){
 		$search = mysql_escape_string($search);		
 	}
        
  		
 	$this->db->where($where, NULL, FALSE);
 	$this->db->order_by($sort_field,$sortby);
 	$this->db->limit($limit,$start);
 	$query = $this->db->get();
        //echo $this->db->last_query();

 	$result = $query->result_array();

 	return $result;
	
 	
 }';


        $model .= '
            function count_all_rows($search="") {
            
                $this->db->select("COUNT(*) AS numrows");
                $this->db->from($this->_table);
                $where = "is_active = 1";
                        if(!empty($search)){
                        //search condition      
                        }
                         

                $this->db->where($where, NULL, FALSE);
                return $this->db->get()->row()->numrows;
                }


        ';



        $model .= ' }';
        return $model;
    }

    function build_header($params) {

        $header = '  <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Ciignator for Bootstrap</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//cdn.datatables.net/1.10.1/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.1/css/jquery.dataTables.css">
        <!-- Bootstrap core CSS -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
      
        <!-- Latest compiled and minified JavaScript -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="http://www.position-relative.net/creation/formValidator/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8">
        </script>
        <script src="http://www.position-relative.net/creation/formValidator/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
	  <link rel="stylesheet" href="http://www.position-relative.net/creation/formValidator/css/validationEngine.jquery.css">

        </script>
        <script src="http://www.position-relative.net/creation/formValidator/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
        </script>

    </head>

    <body>

        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

            </div>';
        return $header;
    }

    function build_footer($params) {

        $footer = '   <div class="footer">
                        <p>&copy; Company 2014</p>
                    </div>
                </div>
                    </body>
                    </html>';
        return $footer;
    }

}

?>
