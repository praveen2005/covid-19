<?php
// $pop = file_get_contents('includes/poparrays.json');
// $pop = json_decode($pop, true);
if($now == $today){
    $array = $data;
}
else{
    $array = $timeseries;
}
foreach($array as $Key=> $State){    
    if($scode[$Key] != $name){
        continue;
    } 
    if($now == $today){    
    $conf = $State['delta']['confirmed'];
    $rec = $State['delta']['recovered'];
    $dec = $State['delta']['deceased'];
    $act = $conf-($rec+$dec);

    $tconf = $State['total']['confirmed'];
    $trec = $State['total']['recovered'];
    $tdec = $State['total']['deceased'];
    $test = $State['total']['tested'];
    $tact = $tconf-($trec+$tdec);
    }

    else{    
        $conf = $State[$now]['delta']['confirmed'];
        $rec = $State[$now]['delta']['recovered'];
        $dec = $State[$now]['delta']['deceased'];
        $act = $conf-($rec+$dec);
    
        $tconf = $State[$now]['total']['confirmed'];
        $trec = $State[$now]['total']['recovered'];
        $tdec = $State[$now]['total']['deceased'];
        $test = $State[$now]['total']['tested'];
        $tact = $tconf-($trec+$tdec);
    }

    if($conf>0)
        $conf = "↑ ".$conf;
    if(!$conf)
        $conf = "♥︎";
    if($rec)
        $rec = "↑ ".$rec;
    else
        $rec = "♥︎";
    if($dec)
        $dec = "↑ ".$dec;
    else
        $dec = "♥︎";
    if($act>0)
        $act = "↑ ".$act;
    if($act<0)
        $act = "↓ ".abs($act);
    if(!$act){
        $act = "♥︎";
    }
    if($conf < 0){
        $conf = "♥︎";           
        $act = "<br>";        
    } 
    
    if(!$tconf)
        $tconf=0;
    if(!$trec)
        $trec=0;
    if(!$tdec)
        $tdec=0;
    if(!$tact)
        $tact=0;   

    foreach($data as $Key=> $State){    
        if($scode[$Key] != $name){
            continue;
        }
        $cpm = round($tconf/$State['meta']['population']*1000000, 2);
    }
    $count = count($stdaily);
    $today = new DateTime("now", new DateTimeZone('Asia/Kolkata')); 
    $c=0;
    $half = ($tconf)/2;    
    foreach($timeseries[$Key] as $key => $check){    
        if($check['total']['confirmed']>=$half){        
            $hdate = $key;
            break;
            };
        }
    
    $double = date_diff(date_create($hdate),$today)->format("%a days");
?>
<div class="row mx-auto"style="width: 90%;">
<div class="row mx-auto" style="width: 70%; margin-top: 50px;display: inline-flex;">
                        <div class="col-auto" style="width: 25%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto">                                            
                                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span style="color: #ed3838;">Confirmed</span></div>
                                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1 col-auto"><span style="color: transparent;  text-shadow: 0 0 0 #ed383887; font-size: medium;"><?= $conf ?></span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?= $tconf ?></span></div>
                                        </div>                                        
                                    </div>                                
                        </div>
                        <div class="col-auto" style="width: 25%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto"> 
                                            <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span style="color: #1579f6;">Active</span></div>
                                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1 col-auto"><span style="color: transparent;  text-shadow: 0 0 0 #1579f687; font-size: medium;"><?= $act?></span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?= $tact ?></span></div>
                                            <div style="font-size: 16px;" class="col-auto"><span><?= "(".round(($tact/$tconf*100), 2) ."%)"; ?></span></div>                                      
                                        </div>                                                                                
                                    </div>
                        </div>
                        <div class="col-auto" style="width: 25%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto"> 
                                            <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span style="color: #4ca746;">recovered</span></div>
                                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1 col-auto"><span style="color: transparent;  text-shadow: 0 0 0 #4ca74687; font-size: medium;"><?= $rec ?></span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $trec ?></span></div>
                                            <div style="font-size: 16px;" class="col-auto"><span><?php echo "(".round(($trec/$tconf*100), 2) ."%)"; ?></span></div>                                      
                                        </div>                                                                               
                                    </div>
                        </div>
                        <div class="col-auto" style="width: 25%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto"> 
                                            <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span style="color: #6c757c;">deceased</span></div>
                                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1 col-auto"><span style="color: transparent;  text-shadow: 0 0 0 #6c757c87; font-size: medium;"><?= $dec ?></span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $tdec ?></span></div>
                                            <div style="font-size: 16px;" class="col-auto"><span><?php  echo "(".round(($tdec/$tconf*100), 2) ."%)"; ?></span></div>
                                        </div>                                        
                                    </div>
                        </div>
    </div>
                        <div class="row mx-auto" style="width: 70%; margin-top: 50px; float: right; display: inline-flex;">
                        <div class="col-auto" style="width: 24%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto">
                                            <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span style="color: #ef7c39;">doubling rate</span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?= $double ?></span></div>
                                        </div>                                        
                                    </div>                       
                        </div>
                        <div class="col-auto" style="width: 24%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto"> 
                                            <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span style="color: #7c4bde;">confirmed per million</span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?= $cpm ?></span></div>
                                        </div>                                        
                                    </div>
                        </div>
                        <?php if($test){?>                      
                        <div class="col-auto" style="width: 24%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto">
                                            <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span style="color: #681633;">Total Tested</span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?= round($test/100000, 2) ?> Lakh</span></div>                                            
                                        </div>                                        
                                    </div>                       
                        </div>
                        <?php }?>                        
                        <?php 
                        foreach($timeseries as $Key=> $history){    
                            if($scode[$Key] != $name){
                                continue;
                            }   
                        ?> 
                        <div class="col-auto" style="width: 24%; text-align: center;">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-auto">
                                            <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span style="color: #e63f86;">First Case on</span></div>
                                            <div class="text-dark font-weight-bold h5 mb-0"><span><?= date_format(date_create(array_key_first($history)), "d-M") ?></span></div>
                                        </div>                                        
                                    </div>                       
                        </div>   
                        <?php } ?> 
                        </div> 
                        </div>                                        

<?php } ?>

