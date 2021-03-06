<?PHP
//extension of ?????'s credit card class
//usage is:-
// <$fieldname>= credit_card:check(<$creditcard>, <$validfrom>, <$validto>);
//which returns a parameter array where:-
// $<fieldname>['Valid']	indicates if the card passes the luhn modulo 10 check
// $<fieldname>['CanAccept'] 	indicates if the card is acceptable to your installation
// $<fieldname>['Index'] 	indicates the card type, identified below - count satrts from 10, unless it is unknown
// $<fieldname>['Type']		returns a text string identifying the card eg 'VISA', 'Switch / Maestro' etc....
// $<fieldname>['VTo']		returns true if the "Valid To" date is invalid
// $<fieldname>['VFr']		returns true if the "Valid From" date (or "Issue No") is invalid
//
// Note the 'CanAccept' parameter contravenes the spirit of an open source class - it is very site specific
// most of my customers are unable to accept all cards, so the 'CanAccept' is a kludge workaround to flag
// cards they can or cannot accept. It was getting to hairy to try and develop a scheme which would idetify
// each card type they could or could not use. you may elect to ignore the 'CanAccept' parameter
//
// Copyright notice: there isn't one, you are free to do what you wish with this class, no limits "just do it.."
//
// No warranties are provided, no guarantees, no liabilities, are provided - it is provided "as is" in the
// hope that it may prove usefull to the PHP community, or as a basis for other developments
//
// You are strongly advised to thoroughly test the class before using in a live site.
// author M.W.Heald matthew.heald@virgin.net
// parts of this class are based on a previous author's class contributed to phpclasses.org, sadly I do not
// have that authors name or contact details - but thanks mate - much appreciated.
//
class credit_card
{ function clean_no ($cc_no)
  { // Remove non-numeric characters from $cc_no
    return ereg_replace ('[^0-9]+', '', $cc_no);
  }
  function identifyCard ($cc_no)
  {  // Get card type based on prefix and length of card number
     // I am sure there are smarter ways of implementing this, however due to lack of experience with regexp...
     //in no paticular order
//--------------------------------------------
     if (ereg ('^5[1-5].{14}$', $cc_no))      {return array('Type' => 'Mastercard','Index' => 11, 'CanAccept' => TRUE);}
//--------------------------------------------
     if (ereg ('^6334[5-9].{11}$', $cc_no))   {return array('Type' => 'Solo / Maestro','Index' => 16, 'CanAccept' => FALSE);}
     if (ereg ('^6767[0-9].{11}$', $cc_no))   {return array('Type' => 'Solo / Maestro','Index' => 16, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^564182[0-9].{9}$', $cc_no))  {return array('Type' => 'Switch / Maestro','Index' => 19, 'CanAccept' => FALSE);}
     if (ereg ('^6333[0-4].{11}$', $cc_no))   {return array('Type' => 'Switch / Maestro','Index' => 19, 'CanAccept' => FALSE);}
     if (ereg ('^6759[0-9].{11}$', $cc_no))   {return array('Type' => 'Switch / Maestro','Index' => 19, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^49030[2-9].{10}$', $cc_no))  {return array('Type' => 'Switch','Index' => 18, 'CanAccept' => FALSE);}
     if (ereg ('^49033[5-9].{10}$', $cc_no))  {return array('Type' => 'Switch','Index' => 18, 'CanAccept' => FALSE);}
     if (ereg ('^49110[1-2].{10}$', $cc_no))  {return array('Type' => 'Switch','Index' => 18, 'CanAccept' => FALSE);}
     if (ereg ('^49117[4-9].{10}$', $cc_no))  {return array('Type' => 'Switch','Index' => 18, 'CanAccept' => FALSE);}
     if (ereg ('^49118[0-2].{10}$', $cc_no))  {return array('Type' => 'Switch','Index' => 18, 'CanAccept' => FALSE);}
     if (ereg ('^4936[0-9].{11}$', $cc_no))   {return array('Type' => 'Switch','Index' => 18, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^6011.{12}$', $cc_no))        {return array('Type' => 'Discover Card','Index' => 23, 'CanAccept' => FALSE);}
//--------------------------------------------
     //failing earlier 6xxx xxxx xxxx xxxx checks then its a Maestro card
     if (ereg ('^6[0-9].{14}$', $cc_no))      {return array('Type' => 'Maestro','Index' => 20, 'CanAccept' => FALSE);}
     if (ereg ('^5[0,6-8].{14}$', $cc_no))    {return array('Type' => 'Maestro','Index' => 20, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^450875[0-9].{9}$', $cc_no))  {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^48440[6-8].{10}$', $cc_no))  {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^48441[1-9].{10}$', $cc_no))  {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^4844[2-4].{11}$', $cc_no))   {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^48445[0-5].{10}$', $cc_no))  {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^4917[3-5].{11}$', $cc_no))   {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^491880[0-9].{9}$', $cc_no))  {return array('Type' => 'UK Electron','Index' => 21, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^41373[3-7].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^4462[0-9].{11}$', $cc_no))  {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^45397[8-9].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^454313[0-9].{9}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^45443[2-5].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^454742[0-9].{9}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^45672[5-9].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^45673[0-9].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^45674[0-5].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^4658[3-7].{11}$', $cc_no))  {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^4659[0-5].{11}$', $cc_no))  {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^484409[0-9].{9}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^48441[0-9].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^4909[6-7].{11}$', $cc_no))  {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^49218[1-2].{10}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
     if (ereg ('^498824[0-9].{9}$', $cc_no)) {return array('Type' => 'Visa Delta','Index' => 13, 'CanAccept' => TRUE);}
//--------------------------------------------
     if (ereg ('^40550[1-4].{10}$', $cc_no)) {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^40555[0-4].{10}$', $cc_no)) {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^415928[0-4].{9}$', $cc_no)) {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^42460[4-5].{10}$', $cc_no)) {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^427533[0-9].{9}$', $cc_no)) {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^4288[0-9].{11}$', $cc_no))  {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^443085[0-9].{9}$', $cc_no)) {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^448[4-6].{12}$', $cc_no))   {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^471[5-6].{12}$', $cc_no))   {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
     if (ereg ('^4804[0-9].{11}$', $cc_no))  {return array('Type' => 'Visa Purchasing','Index' => 12, 'CanAccept' => TRUE);}
//--------------------------------------------
     if (ereg ('^49030[0-1].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^4903[1-2].{11}$', $cc_no))   {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49033[0-4].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^4903[4-9].{11}$', $cc_no))   {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49040[0-9].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^490419[0-9].{9}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^490451[0-9].{9}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^490459[0-9].{9}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^490467[0-9].{9}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49047[5-8].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^4905[0-9].{11}$', $cc_no))   {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^491001[0-9].{9}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49110[3-9].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^4911[1-6].{11}$', $cc_no))   {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49117[0-3].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49118[3-9].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^49119[0-9].{10}$', $cc_no))  {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^4928[0-9].{11}$', $cc_no))   {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
     if (ereg ('^4987[0-9].{11}$', $cc_no))   {return array('Type' => 'Visa ATM','Index' => 14, 'CanAccept' => FALSE);}
//--------------------------------------------
     //failing earlier 4xxx xxxx xxxx xxxx checks then it must be a Visa
     if (ereg ('^4(.{12}|.{15})$', $cc_no))   {return array('Type' => 'Visa','Index' => 12, 'CanAccept' => TRUE);}
//--------------------------------------------
     if (ereg ('^3[4-7].{13}$', $cc_no))       {return array('Type' => 'American Express','Index' => 18, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^3(0[0-5].{11}|[6].{12}|[8].{12})$', $cc_no)) {return array('Type' => 'Diners Club/Carte Blanche','Index' => 19, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^(3.{15}|(2131|1800).{11})$', $cc_no)){return array('Type' => 'JCB','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^(3528[0-9].{11})$', $cc_no)) {return array('Type' => 'JCB','Index' => 21, 'CanAccept' => FALSE);}
     if (ereg ('^(35[3-8].{13})$', $cc_no))   {return array('Type' => 'JCB','Index' => 21, 'CanAccept' => FALSE);}
//--------------------------------------------
     if (ereg ('^2(014|149).{11})$', $cc_no)) {return array('Type' => 'enRoute','Index' => 22, 'CanAccept' => FALSE);}
//the following are from http://www.merriampark.com/anatomycc.htm
//put in for 'fullness' - the following indicate the broad type of card
//if you are in a business that can reasonably be expected to accept fuel cards then you could accept cards starting with a 7
//please note I do not know how many digits there could be on the card, some specs suggest that cards can have
//upto 19 digits including the check digit.
//
//cards starting with a ? are issued by the following industry sectors
//	0	ISO/OTC 68 and related industries - if you know what that means good luck
//	1	Airlines
//	2	Airlines and other industries
//	3	Travel and Entertainment	comment : AMEX / Cart Blanche etc
//	4	Banking and Financial		comment : read VISA
//	5	Banking and Financial		comment : read MasterCard
//	6	Merchandising and Banking	comment : read store cards, bank cash cards / EFT cards
//	7	Petroleum			comment : read fuel cards
//	8	Telecomm and related
//	9	National assignements		comment : who knows, who cares?
//--------------------------------------------
    return array('Type' => 'unknown or invalid','Index' => 0, 'CanAccept' => FALSE);
  }
  function validate($cc_no)
//implements the 'Luhn' modulo 10 check on the supplied number
  { $cc_no=strrev($cc_no);
    $NoDigits=strlen($cc_no);
    $TestSum=0;
    for ($Digit=0;$Digit<$NoDigits; $Digit=$Digit+2)
    { $TestSum=$TestSum+($cc_no[$Digit]) + credit_card::SingleDigit(($cc_no[$Digit+1]*2));
    }
    if (floor($TestSum/10)!=($TestSum/10)) { return FALSE;} else { return TRUE;}
  }
  function SingleDigit($iDigit) //if the number is greater than 10 subtract 9 to generate a single digit
  { if ($iDigit>=10) {$iDigit=$iDigit-9;} //reqired for the Luhn check
    return $iDigit;
  }
  function CheckDates($VFrom,$VTo)
  { //this function validates the dates
    //the valid from can be mm/yy or xx or NULL (a date, or issue number or nothing)
    //set the default value
    $ErrorCode['VFrom']=FALSE;	//indicates the Valid From / Issue number has an error
    $ErrorCode['VTo']=FALSE;	//indicates the Valid To date has an error
    //vfrom is either a 2 digit number OR as date in the form mm/yy
    if (isset($VFrom)==TRUE)
    { if (strlen($VFrom)==2)
      { if (ereg("^[[:digit:]]{2}$",$VFrom)!=TRUE)
        { $ErrorCode['VFrom']=TRUE;
        }
      //otherwise presume it must be a date in the form mm/yy
      } elseif (strlen($VFrom)==5)
      { if (ereg("^[[:digit:]/[:digit:]]${5}",$VFrom)!=TRUE)
        { $ErrorCode['VFrom']=TRUE;
        } else
        { $tVFr = explode("/",$VFrom);
          if ($tVFr[0] <=0 or $tVFr[0]>=13)
          { $ErrorCode['VFrom']=TRUE;
          }
          if ($tVFr[1] > date(y)) //year cannot be greater than current year
          { $ErrorCode['VFrom']=TRUE;
          } elseif ($tVFr[1] == date(y)) //if the years are the same then the month cannot be greater than the current month
          { if ($tVFr[0]>date(m))
            { $ErrorCode['VFrom']=TRUE;
            }
          }
        }
      } elseif (strlen($VFrom)>0) //catch all (ie neither 2 or 5 characters supplied
      { $ErrorCode['VFrom']=TRUE;
      }
    }
    if (isset($VTo)==TRUE)
    { if (strlen($VTo)==5)
      { if (ereg("^[[:digit:]/[:digit:]]${5}",$VTo)!=TRUE)
        { $ErrorCode['VTo']=TRUE;
        } else
        { $tVTo = explode("/",$VTo);
          if ($tVTo[0] <=0 or $tVTo[0]>=13)
          { $ErrorCode['VTo']=TRUE;
          }
          if ($tVTo[1] < date(y)) //year cannot be less than current year
          { $ErrorCode['VTo']=TRUE;
          } elseif ($tVTo[1] == date(y)) //if the years are the same then the month cannot be less than the current month
          { if ($tVTo[0]<date(m))
            { $ErrorCode['VTo']=TRUE;
            }
          }
        }
      } else
      { $ErrorCode['VTo']=TRUE;
      }
    }
    // so finally the From date MUST be less than or equal to the To date
    return array('VTo'=> $ErrorCode['VTo'],'VFr'=> $ErrorCode['VFrom']);
  }
  function check($cc_no,$VFr,$VTo)
  {  $cc_no = credit_card::clean_no($cc_no);
     $valid = credit_card::validate ($cc_no);
     $CCData = credit_card::IdentifyCard ($cc_no);
     $Dates = credit_card::CheckDates($VFr,$VTo);
     return array ('Valid' => $valid, 'CanAccept' => $CCData['CanAccept'], 'Index'=> $CCData['Index'], 'Type'=>$CCData['Type'],'VTo' => $Dates['VTo'], 'VFr'=>$Dates['VFr']);
  }
}
?>