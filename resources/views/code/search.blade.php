@extends('layouts.app')
@section('title', 'SportCenters')

@section('title_html')
    <h1>Sport Centers</h1>
@endsection

@section('content')



        
        <div class="card card-style overflow-visible" style="z-index: 1;">
            <div class="content mb-0"> 
    
                
                <!-- set your categories here, using the value as the data-filter-->
                <div class="input-style input-style-2 mb-0">
                    <span class="input-style-1-active"></span>
                    <em><i class="fa fa-angle-down"></i></em>
                    <select id="filter-select" class="form-control">
                        <option value="all" selected>All Region</option>
                        @foreach($detail as $item)
                        <option value="{{$item->id}}">{{$item->region}}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- these are the actual controls. copy your aboce selects here, be sure value and data-filter are the same-->
                
                
            </div>
            <div class="content mt-0 mb-3">
                <div class="gallery gallery-filter-select">
                   
                    @foreach($fetch as $item)
                <a href="https://app.sportm4te.com/sport-details/{{$item->id}}" class="filtr-item" title="{{$item->name}}" data-category="{{$item->id}}">
                <img src="https://partner.sportm4te.com/storage/uploads/{{$item->imgName}}"class="reload-img rounded-s shadow-m" width="100%" alt="" srcset="">
                   <h4>{{$item->name}}</h4>
                    </a>
                    <p>
                    {{$item->description}}
                    </p>
                    @foreach($detail as $item)
                    <li data-filter="all" style="list-style-type: none;">
                    <i class="far fa-clock"> </i>   
                    Open: 08:00 AM to 07:00 PM</li>
                    <li data-filter="all" style="list-style-type: none;">
                    <i class="fa font-14 fa-map-marker"></i>
                    City: {{$item->city}}
                    </li>
                  @endforeach

                    @endforeach
                  
                   
                </div>
            </div>
        </div>
     

<!-- Page content ends here-->

<!-- Main Menu-->

</div>


</div>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
@endsection