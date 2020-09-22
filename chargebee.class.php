<?php

  class ChargeBee_Wrapper{

    function __construct(string $site, string $api_key){
      ChargeBee_Environment::configure($site,$api_key);
    }

    public function User_Get(string $u_id){
      try{
        $result = ChargeBee_Customer::retrieve($id);
        $customer = $result->customer();
        return $customer;
      } catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Create(): Error - " . $ex);
        return false;
        die();
      }
    }

    public function User_Create(array $arr_user = null){
      try{
        $result = ChargeBee_Customer::create($arr_user);
        $customer = $result->customer();
        return $customer->id;
      } catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Create(): Error - " . $ex);
        return false;
        die();
      }
    }

    public function User_Remove(string $u_id) : bool{
      try{
        $result = ChargeBee_Customer::delete($u_id);
        return true;
      } catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Remove(): Error - " . $ex);
        return false;
        die();
      }
    }

    public function User_Sub_Add(string $u_id, array $info){
      try{
        $result = ChargeBee_Subscription::createForCustomer($u_id, $info);
        $subscription = $result->subscription();
        return $subscription->id;
      }catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Add_Sub(): Error - " . $ex);
        return false;
        die();
      }

    }

    public function User_Sub_Remove(string $sub_id) : bool{
      try{
        $result = ChargeBee_Subscription::delete($sub_id);
        return true;
      }catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Remove_Sub(): Error - " . $ex);
        return false;
        die();
      }
    }

    public function User_Sub_Update(string $sub_id, array $info){
      try{
        $result = ChargeBee_Subscription::update($sub_id, $info);
        return true;
      }catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Sub_Update(): Error - " . $ex);
        return false;
        die();
      }
    }

    public function User_Addon_Add(string $sub_id, string $addon_id, int $quantity = 1){
      try{
        $result = ChargeBee_Subscription::update($sub_id, array(
          "addons" => array(
            array(
              'id' => $addon_id,
              'quantity' => $quantity
            ),
          ),
        ));
        return true;
      } catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Addon_Add(): Error - " . $ex);
        return false;
        die();
      }
    }

    public function User_Addon_Remove(string $sub_id, string $addon_id, int $quantity) : bool{
      try{

        // ? Call API finally with appropriate addon array
        $result = ChargeBee_Subscription::update($sub_id, array(
          "replaceAddonList" => true,
          // "addons" => null,
        ));
        return true;

      } catch(\Exception $ex){
        error_log("ChargeBee_Wrapper->User_Addon_Remove(): Error - " . $ex);
        return false;
        die();
      }
    }

  }

  $cb_site = "";
  $cb_key = "";
  $cb = new ChargeBee_Wrapper($cb_site, $cb_key);
