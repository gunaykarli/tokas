<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealersMemberCode extends Model
{
    protected $fillable = ['vodafone_UVP', 'vodafone_GVO', 'vodafone_DSL_UVP', 'mobilcom_debitel_UVP', 'energie_user', 'yourfone_UVP',
        'ayyildiz_UVP', 'blau_UVP', 'otelo_neu', 'otelo_alt'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    //add member code of the Dealer with $dealerID sent from DealerCpntroller@store
    public function addMemberCodeOfDealer ($dealerID, $request){

        $dealersMemberCode = new DealersMemberCode();

        $dealersMemberCode->dealer_id = $dealerID;
        $dealersMemberCode->vodafone_UVP = $request->vodafoneUVP;
        $dealersMemberCode->vodafone_GVO = $request->vodafoneGVO;
        $dealersMemberCode->vodafone_DSL_UVP = $request->vodafoneDSLUVP;
        $dealersMemberCode->mobilcom_debitel_UVP = $request->mobilcomDebitelUVP;
        $dealersMemberCode->energie_user = $request->energieUser;
        $dealersMemberCode->yourfone_UVP = $request->yourfoneUVP;
        $dealersMemberCode->ayyildiz_UVP = $request->ayyildizUVP;
        $dealersMemberCode->blau_UVP = $request->blauUVP;
        $dealersMemberCode->otelo_neu = $request->oteloNeu;
        $dealersMemberCode->otelo_alt = $request->oteloAlt;


        $dealersMemberCode->save();

        //ÇALIŞMIYOR...
        //return redirect()->home();
    }

    public function updateMemberCodeOfDealer ($dealersMemberCode, $request){

        //$dealersMemberCode->dealer_id = $dealerID;
        $dealersMemberCode->vodafone_UVP = $request->vodafoneUVP;
        $dealersMemberCode->vodafone_GVO = $request->vodafoneGVO;
        $dealersMemberCode->vodafone_DSL_UVP = $request->vodafoneDSLUVP;
        $dealersMemberCode->mobilcom_debitel_UVP = $request->mobilcomDebitelUVP;
        $dealersMemberCode->energie_user = $request->energieUser;
        $dealersMemberCode->yourfone_UVP = $request->yourfoneUVP;
        $dealersMemberCode->ayyildiz_UVP = $request->ayyildizUVP;
        $dealersMemberCode->blau_UVP = $request->blauUVP;
        $dealersMemberCode->otelo_neu = $request->oteloNeu;
        $dealersMemberCode->otelo_alt = $request->oteloAlt;

        $dealersMemberCode->save();

        //ÇALIŞMIYOR...
        //return redirect()->home();
    }
}
