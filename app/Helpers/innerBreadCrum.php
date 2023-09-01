<?php
function innerBreadCrum($breadCrumb = null)
{
    // template for view 
    // acitve property for current page
    // @php
    // $breadCumb=[
    //     ['path'=>url('/'),'title'=>'Home','active'=>false],
    //     ['path'=>'','title'=>'Materials','active'=>false],
    //     ['path'=>route('new.part.dashboard'),'title'=>'Parts','active'=>false],
    //     ['path'=> Request::url() ,'title'=>'Edit Part','active'=>true]
    // ]
    // @endphp

    $Bd='<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">';
            foreach ($breadCrumb as $item){

                if($item['active']==true){

                    $Bd.='<li class="breadcrumb-item text-dark">'.$item['title'].'</li>';

                }else{

                    $Bd.='<li class="breadcrumb-item text-muted">';
                    $Bd.=$item['path'] ? '<a href="'.$item['path'].'" class="text-muted text-hover-primary">'.$item['title'].'</a>' :   $item['title'] .'</li>';

                }

                if ($item['active'] == false){
                    $Bd.='<li class="breadcrumb-item">
                        <span class="bullet bg-gray-350 w-5px h-2px"></span>
                    </li>';
                }

            }
            $Bd.='</ul>';
        return $Bd;
    // end::Breadcrumb
}