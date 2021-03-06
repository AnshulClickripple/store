
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Stores extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $language = $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common", $language);
        $this->dataModule['cuisine'] = $this->Sitefunction->get_rows(TBL_CUISINE, 'id, title', array('status' => 1));
        $this->dataModule['country'] = $this->Sitefunction->get_rows(TBL_COUNTRY, 'id, name', array('status' => 1));
        $this->dataModule['owners'] = $this->Sitefunction->get_rows(TBL_STORE_OWNERS, 'id, first_name, last_name', array('status' => 1));
    }
    public function index()
    {
        $where = array('r.status!=' => 9);
        $columns = "r.*, o.first_name, o.last_name, s.name as state_name, ct.name as city_name, c.name as country_name";
        $join = array(TBL_STATE . ' as s' => "s.id=r.state_id", TBL_CITY . ' as ct' => "ct.id=r.city_id", TBL_COUNTRY . " as c" => "c.id=r.country_id", TBL_STORE_OWNERS . " as o" => "o.id=r.owner_id");
        $group_by = 'r.id';
        $this->dataModule['results'] =  $this->Sitefunction->get_all_rows(TBL_STORES . ' as r', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());

        $this->load->view('stores/index', $this->dataModule);
    }

    public function delete()
    {

        $this->Sitefunction->delete(TBL_STORES, array('id' => $this->input->get_post('id')));
    }

    public function multiple_delete()
    {
        $ids = $this->input->get_post('id');

        foreach ($ids as $id) {
            $this->Sitefunction->delete(TBL_STORES, array('id' => $id));
        }
    }

    public function add()
    {
        $postData = $this->input->post();
        if ($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('owner_id', 'owner', 'required');
            $this->form_validation->set_rules('phone_number', 'phone', 'required|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|min_length[3]|max_length[125]');

//            $this->form_validation->set_rules('cuisine_id', 'cuisine', 'required');
            // $this->form_validation->set_rules('city_id', 'city', 'required');
            // $this->form_validation->set_rules('state_id', 'state', 'required');
            // $this->form_validation->set_rules('country_id', 'country', 'required');
            // $this->form_validation->set_rules('pincode', 'pincode', 'required|min_length[5]|max_length[7]');

            $this->form_validation->set_rules('address', 'address', 'required|min_length[10]');
            $this->form_validation->set_rules('opening_time', 'opening time', 'required');
            $this->form_validation->set_rules('closing_time', 'closing time', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            if ($this->form_validation->run() != FALSE) {
                $data_array['name'] = ($this->input->post('name'));
                $data_array['owner_id'] = $this->input->post('owner_id');
                $data_array['email'] = ($this->input->post('email_id'));
                $data_array['phone'] = $this->input->post('phone_number');
                //$data_array['cuisine_id'] = $this->input->post('cuisine_id');
                // $data_array['city_id'] = $this->input->post('city_id');
                // $data_array['state_id'] = $this->input->post('state_id');
                // $data_array['country_id'] = $this->input->post('country_id');
                // $data_array['pincode'] = $this->input->post('pincode');

                $data_array['address'] = ($this->input->post('address'));
                $data_array['discount'] = $this->input->post('discount');
                $data_array['discount_type'] = $this->input->post('discount_type');
                $data_array['average_price'] = $this->input->post('average_price');
                $data_array['opening_time'] = date('H:i:s', strtotime($this->input->post('opening_time')));
                $data_array['closing_time'] = date('H:i:s', strtotime($this->input->post('closing_time')));
                $data_array['updated'] = $this->utc_time;
                $data_array['created'] = $this->utc_time;
                $address = ($data_array['address']); // . ' ' . $data_array['pincode']; // Google HQ
                $prepAddr = str_replace(' ', '+', $address);
                //$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=AIzaSyB6bhsghvjbvVvHmTSUTQiSCSr9QJo0EcA');
//                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=' . $this->settings->map_api_key);
                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=AIzaSyB6bhsghvjbvVvHmTSUTQiSCSr9QJo0EcA' );
                $output = json_decode($geocode);

                if ($output->results[0] && $output->results[0]->geometry && $output->results[0]->geometry->location && $output->results[0]->geometry->location->lat) {
                    $latitude = $output->results[0]->geometry->location->lat;
                    $longitude = $output->results[0]->geometry->location->lng;
                    $cityName = $output->results[0]->address_components[3]->long_name;
                    $stateName = $output->results[0]->address_components[5]->long_name;
                    $countryName = $output->results[0]->address_components[6]->long_name;
                    $zipCode = $output->results[0]->address_components[7]->long_name;

                    $con = mysqli_connect("localhost:3306", "root", "prabhs226", "delivery_eztakeout");
                    if (!mysqli_connect_errno()) {
                        $sql1 = "Select * from tbl_city where name = '" . $cityName . "';";
                        $resultCityID = mysqli_query($con, $sql1);
                        while ($rowCityID = mysqli_fetch_array($resultCityID)) {
                            $data_array['city_id'] = $rowCityID['id'];
                            break;
                        }


                        $sql2 = "Select * from tbl_state where name = '" . $stateName . "';";
                        $resultStateID = mysqli_query($con, $sql2);
                        while ($rowStateID = mysqli_fetch_array($resultStateID)) {
                            $data_array['state_id'] = $rowStateID["id"];
                            break;
                        }

                        $sql3 = "Select * from tbl_country where name = '" . $countryName . "';";
                        $resultCountryID = mysqli_query($con, $sql3);
                        while ($rowCountryID = mysqli_fetch_array($resultCountryID)) {
                            $data_array['country_id'] = $rowCountryID["id"];
                            break;
                        }
                    }
                    $data_array['pincode'] = $zipCode;
                    $data_array['latitude'] = $latitude;
                    $data_array['longitude'] = $longitude;
                    if (isset($_FILES['profile_image']) && $_FILES['profile_image'] != '') {
                        $fileCount = count($_FILES["profile_image"]['name']);

                        $p_profile_image = array();
                        for ($pi = 0; $pi < $fileCount; $pi++) {
                            $randdom = round(microtime(time() * 1000)) . rand(000, 999);
                            $file_extension1 = pathinfo($_FILES["profile_image"]["name"][$pi], PATHINFO_EXTENSION);
                            $file_name1 = $randdom . '.' . $file_extension1;
                            if ($_FILES["profile_image"]["error"][$pi] > 0) {
                                $file_name1 = '';
                            } else {
                                move_uploaded_file($_FILES['profile_image']['tmp_name'][$pi], UPLOAD_PATH . 'restaurants/profile/' . $file_name1);
                                array_push($p_profile_image,  $file_name1);
                            }
                        }
                        $p_profile_image1 = implode(',', $p_profile_image);
                    } else {
                        $p_profile_image1 = '';
                    }
                    $data_array['profile_image'] = $p_profile_image1;
                    if ($this->Sitefunction->insert(TBL_STORES, $data_array)) {
                        $this->session->set_flashdata('success', $this->lang->line('restaurant_added_successfully'));
                        redirect(STORES_PATH);
                    } else {
                        $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('invalid_address'));
                }
            }
        }
        $this->load->view('stores/add', $this->dataModule);
    }

    public function edit($id)
    {
        $this->dataModule['results'] = $this->Sitefunction->get_single_row(TBL_STORES, '*', array('id' => $id));
        if (!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData = $this->input->post();
        if ($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('owner_id', 'owner', 'required');
            $this->form_validation->set_rules('phone_number', 'phone', 'required|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|min_length[3]|max_length[125]');
            // $this->form_validation->set_rules('city_id', 'city', 'required');
            // $this->form_validation->set_rules('state_id', 'state', 'required');
            // $this->form_validation->set_rules('country_id', 'country', 'required');
            // $this->form_validation->set_rules('pincode', 'pincode', 'required|min_length[5]|max_length[7]');
            $this->form_validation->set_rules('address', 'address', 'required|min_length[10]');
            $this->form_validation->set_rules('opening_time', 'opening time', 'required');
            $this->form_validation->set_rules('closing_time', 'closing time', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            if ($this->form_validation->run() != FALSE) {
                $data_array['name'] = ($this->input->post('name'));
                $data_array['owner_id'] = $this->input->post('owner_id');
                $data_array['email'] = ($this->input->post('email_id'));
                $data_array['phone'] = $this->input->post('phone_number');
                // $data_array['city_id'] = $this->input->post('city_id');
                // $data_array['state_id'] = $this->input->post('state_id');
                // $data_array['country_id'] = $this->input->post('country_id');
                // $data_array['pincode'] = $this->input->post('pincode');
                $data_array['address'] = ($this->input->post('address'));
                $data_array['discount'] = $this->input->post('discount');
                $data_array['discount_type'] = $this->input->post('discount_type');
                $data_array['average_price'] = $this->input->post('average_price');
                $data_array['opening_time'] = date('H:i:s', strtotime($this->input->post('opening_time')));
                $data_array['closing_time'] = date('H:i:s', strtotime($this->input->post('closing_time')));
                $address = ($data_array['address']); // . ' ' . $data_array['pincode']; // Google HQ
                $prepAddr = str_replace(' ', '+', $address);
                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=AIzaSyB6bhsghvjbvVvHmTSUTQiSCSr9QJo0EcA' );
//                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=' . $this->settings->map_api_key);
                $output = json_decode($geocode);

                if ($output->results[0] && $output->results[0]->geometry && $output->results[0]->geometry->location && $output->results[0]->geometry->location->lat) {
                    $latitude = $output->results[0]->geometry->location->lat;
                    $longitude = $output->results[0]->geometry->location->lng;
                    $cityName = $output->results[0]->address_components[3]->long_name;
                    $stateName = $output->results[0]->address_components[5]->long_name;
                    $countryName = $output->results[0]->address_components[6]->long_name;
                    $zipCode = $output->results[0]->address_components[7]->long_name;

                    $con = mysqli_connect("127.0.0.1", "root", "", "delivery_app");
                    if (!mysqli_connect_errno()) {
                        $sql1 = "Select * from tbl_city where name = '" . $cityName . "';";
                        $resultCityID = mysqli_query($con, $sql1);
                        while ($rowCityID = mysqli_fetch_array($resultCityID)) {
                            $data_array['city_id'] = $rowCityID['id'];
                            break;
                        }


                        $sql2 = "Select * from tbl_state where name = '" . $stateName . "';";
                        $resultStateID = mysqli_query($con, $sql2);
                        while ($rowStateID = mysqli_fetch_array($resultStateID)) {
                            $data_array['state_id'] = $rowStateID["id"];
                            break;
                        }

                        $sql3 = "Select * from tbl_country where name = '" . $countryName . "';";
                        $resultCountryID = mysqli_query($con, $sql3);
                        while ($rowCountryID = mysqli_fetch_array($resultCountryID)) {
                            $data_array['country_id'] = $rowCountryID["id"];
                            break;
                        }
                    }

                    $data_array['pincode'] = $zipCode;
                    $data_array['latitude'] = $latitude;
                    $data_array['longitude'] = $longitude;
                    if (isset($_FILES['profile_image']) && $_FILES['profile_image'] != '') {


                        $fileCount = count($_FILES["profile_image"]['name']);

                        $p_profile_image = $_POST['happening_gallery_image'] != '' ? $_POST['happening_gallery_image'] : array();
                        for ($pi = 0; $pi < $fileCount; $pi++) {
                            $randdom = round(microtime(time() * 1000)) . rand(000, 999);
                            $file_extension1 = pathinfo($_FILES["profile_image"]["name"][$pi], PATHINFO_EXTENSION);
                            $file_name1 = $randdom . '.' . $file_extension1;
                            if ($_FILES["profile_image"]["error"][$pi] > 0) {
                                $file_name1 = '';
                            } else {
                                move_uploaded_file($_FILES['profile_image']['tmp_name'][$pi], UPLOAD_PATH . 'restaurants/profile/' . $file_name1);
                                array_push($p_profile_image,  $file_name1);
                            }
                        }
                        $p_profile_image1 = implode(',', $p_profile_image);
                    } else {
                        $p_profile_image1 = $this->dataModule['results']->profile_image;
                    }
                    $data_array['profile_image'] = $p_profile_image1;
                    $data_array['updated'] = $this->utc_time;
                    if ($this->Sitefunction->update(TBL_STORES, $data_array, array('id' => $id))) {
                        $this->session->set_flashdata('success', $this->lang->line('restaurant_updated_successfully'));
                        redirect(STORES_PATH);
                    } else {
                        $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('invalid_address'));
                }
            }
        }
        $this->dataModule['state'] = $this->Sitefunction->get_rows(TBL_STATE, 'id, name', array('status' => 1, 'country_id' => $this->dataModule['results']->country_id));
        $this->dataModule['city'] = $this->Sitefunction->get_rows(TBL_CITY, 'id, name', array('status' => 1, 'state_id' => $this->dataModule['results']->state_id));
        $this->load->view('stores/edit', $this->dataModule);
    }

    function getState()
    {
        $country_id = $this->input->get_post('country_id');
        $getstate = $this->Sitefunction->get_rows(TBL_STATE, 'id, name', array('status' => 1, 'country_id' => $country_id));
        $result = '<option value="">' . $this->lang->line('select_state') . '</option>';
        foreach ($getstate as $value) {
            $result .= '<option value="' . $value['id'] . '">' . ($value['name']) . '</option>';
        }
        echo $result;
    }
    function getCity()
    {
        $state_id = $this->input->get_post('state_id');
        $getcity = $this->Sitefunction->get_rows(TBL_CITY, 'id, name', array('status' => 1, 'state_id' => $state_id));
        $result = '<option value="">' . $this->lang->line('select_city') . '</option>';
        foreach ($getcity as $value) {
            $result .= '<option value="' . $value['id'] . '">' . ($value['name']) . '</option>';
        }
        echo $result;
    }

    public function view($id)
    {

        $this->dataModule['restaurant_info'] =  $this->Sitefunction->get_single_by_query("SELECT r.*, ct.name as city_name, s.name as state_name, c.name as country_name FROM " . TBL_STORES . " as r INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id  INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id WHERE r.id=" . $id . " and r.status=1");
        $this->dataModule['controller'] = $this;

        $where = array('s.restaurant_id=' => $id, 's.status' => 1);
        $columns = "c.*";
        $join = array(TBL_SUBCATEGORIES . ' as s' => "s.category_id=c.id");
        $group_by = 'c.id';
        $this->dataModule['categories'] =  $this->Sitefunction->get_all_rows(TBL_CATEGORIES . ' as c', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());




        if (empty($this->dataModule['restaurant_info'])) {
            $this->session->set_flashdata('error', $this->lang->line('order_not_found'));
            redirect(STORES_PATH);
        }

        $this->load->view("stores/view", $this->dataModule);
    }

    function invoice($id)
    {

        $where = array('o.restaurent_id=' => $id, 'o.status' => 1, 'e.status' => 1);
        $columns = "o.*, e.admin_charge_amount, e.owners_amount, e.total_amount, e.payment_status, e.payment_date";
        $join = array(TBL_EARNINGS . ' as e' => "e.order_id=o.id");
        $group_by = 'o.id';
        $this->dataModule['invoice_info'] =  $this->Sitefunction->get_all_rows(TBL_ORDERS . ' as o', $columns, $where, $join, array('o.id' => 'desc'), '', 'INNER', array(), $group_by, array(), array());

        $this->dataModule['controller'] = $this;
        $this->dataModule['restaurant_id'] = $id;
        $this->load->view("stores/invoice", $this->dataModule);
    }

    function pay($id, $payable_Amount)
    {


        if ($this->sendInvoiceEmailToOwner($id, $payable_Amount)) {
            $this->Sitefunction->update(TBL_EARNINGS, array('payment_status' => 1, 'payment_date' => $this->utc_time), array('restaurent_id' => $id, 'payment_status' => 0, 'status' => 1));
            $this->session->set_flashdata('success', $this->lang->line('payment_mail_sent'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
        }
        redirect(STORES_PATH . '/invoice/' . $id);
    }
}
?>
