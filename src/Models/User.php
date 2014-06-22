<?php
namespace Skeleton\Models;
use \FourOneOne\ActiveRecord\ActiveRecord;

class User extends ActiveRecord{
  protected $_table = "users";

  public $user_id;
  public $username;
  public $displayname;
  public $password;
  public $email;
  public $created;
  public $type;

  public function is_admin(){
    if($this->type == 'Admin'){
      return true;
    }
    return false;
  }

  public function set_password($password){
    // TODO: Something a bit better than SHA1 I think.
    $this->password = hash("SHA1", $password);
    return $this;
  }

  static public function check_logged_in(){
    if(self::get_current() instanceof User){
      return false;
    }else{
      header("Location: /login");
      exit;
    }
  }

  /**
   * Get the current user.
   * @return User|false
   */
  static public function get_current(){
    if(isset($_SESSION['user'])){
      if($_SESSION['user'] instanceof User){
        return User::search()->where('user_id', $_SESSION['user']->user_id)->execOne();
      }
    }
    return false;
  }

  /**
   * Get users addressbook.
   *
   * @return AddressBook[]|false
   */
  public function get_addresses(){
    return AddressBook::search()->where('user_id', $this->user_id)->exec();
  }

  /**
   * @return Balance[]|false
   */
  public function get_balances(Coin $coin = null, $sort_by = null, $direction = null){
    $query = BalanceConfirmed::search();
    $query->where('user_id', $this->user_id);

    if($coin !== null){
      $query->where('coin_id', $coin->coin_id);
    }

    if($sort_by !== null){
      $query->order($sort_by, $direction);
    }
    return $query->exec();
  }

  public function pay_from_specific_account($address, Account $account, $amount){
    $query = BalanceConfirmed::search();
    $query->where('user_id', $this->user_id);
    $query->where('coin_id', $account->get_coin()->coin_id);
    /* @var $balance BalanceConfirmed */
    $balance = $query->execOne();

    $balance->pay($account->get_coin(), $address, $amount);

    Notification::send(
      Notification::Warning,
      "Payed :amount :coin to :address from :origin", array(
        ":amount" => $amount,
        ":coin" => $balance->get_account()->get_coin()->name,
        ":address" => $address,
        ":origin" => $account->name != '' ? $account->name : $account->address,
      )
    );
  }

  public function pay($address, Coin $coin, $amount){
    $amount_initial = $amount;
    $balances = $this->get_balances($coin, 'balance', 'ASC');

    $cum_balance = 0;
    foreach($balances as $balance){
      $cum_balance += $balance->balance; //Snicker snicker tee hee
    }

    if($cum_balance < $amount){
      throw new \Exception("Not enough money available. You have {$cum_balance} available and you requested {$amount}");
    }

    // Loop over balances until paid.
    $transaction_count = 0;
    foreach($balances as $balance){
      if($balance->balance >= $amount){
        $balance->pay($coin, $address, $amount);
        $transaction_count++;
        break;
      }else{
        $amount = $amount - $balance->balance;
        $balance->pay($coin, $address, $balance->balance);
        $transaction_count++;
      }
    }

    Notification::send(
      Notification::Warning,
      "Payed :amount :coin to :address in :transaction_count transactions", array(
        ":amount" => $amount_initial,
        ":coin" => $balance->get_account()->get_coin()->name,
        ":address" => $address,
        ":transaction_count" => $transaction_count
      )
    );
    return true;
  }

}