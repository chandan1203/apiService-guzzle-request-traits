<?php

use App\Traits\ApiService;

use ApiService;

    public function whichGoodsAreInTransit(Request $request)
    {
        // dd($request->all());
        $token = Session::get('authorization_token');

        $which_good_are_in_transit = $this->postCall('/import/which-goods-are-in-transit', $request->all(), $token);

        $compositions = $this->postCall('/import/composition-list', [], $token);
        $lc_no_s = $this->postCall('/import/lc-number-list', [], $token);


        $reports = collect($which_good_are_in_transit->data->data);
        $compositions = collect($compositions->data->composition);
        $lc_no_s = collect($lc_no_s->data->lc_number_list);

        $compositions = $compositions->mapWithKeys(function ($item){
            return [$item->id=>$item->composition];
        });
        $lc_number = $lc_no_s->mapWithKeys(function ($item){
            return [$item->id=>$item->lc_number];
        });

        $paginator = $which_good_are_in_transit->data->paginator;
        // dd($request->all());
        return view('pages.report.whichGoodsAreInTransit', compact('reports', 'compositions', 'lc_number','paginator'));
    }