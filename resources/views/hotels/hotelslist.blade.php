@extends('layouts.app')
@section('content')
<section class="filter-area" ng-controller="HotelsController">

<div class="preloader" ng-if="HotelSearchResult.ResponseStatus !== 1 && HotelSearchResult.ResponseStatus !== 2" >
 <img class="absolute-image" src="/public/images/loader.gif">
</div>
   <div class="container-fluid">
      <div class="row no-gutters">
         <div class="col-lg-3 bg-grey">
            <div class="search-filter">
               <h2 class="full filter-head">
                  <span class="fl">Filter</span>
                  <span class="filter-close"><i class="fas fa-times-circle"></i></span>
               </h2>
               <div class="refine">
                  <h3>Refine Results</h3>
               </div>
               <div class="full-fiter">
                  <div class="byname">
                     <label>Hotel Name</label>
                     <div class="input-group">
                        <input class="form-control" type="text" ng-model="query[queryBy]">
                        <div class="input-group-addon" ><i class="fa fa-search"></i></div>
                     </div>
                  </div>
                  <div class="rating">
                     <p>Star Rating</p>
                     <ul>
                        <li><a href="#">
                           <span>
                           <span class="rating-icon"><i class="fas fa-star"></i></span>
                           </span>
                           <span class="rating-value">1</span>
                           <input class=""  type="checkbox" ng-click="filterRating()" name = "rating[]" data-ng-model='query[searchBy]' ng-true-value='1'  ng-false-value=''/>
                           </a>
                        </li>
                        <li><a href="#">
                           <span>
                           <span class="rating-icon"><i class="fas fa-star"></i></span>
                           </span>
                           <span class="rating-value">2</span>
                           <input class=""  type="checkbox" ng-click="filterRating()" name = "rating[]" data-ng-model='query[searchBy]' ng-true-value='2'  ng-false-value=''/>
                           </a>
                        </li>
                        <li><a href="#">
                           <span>
                           <span class="rating-icon"><i class="fas fa-star"></i></span>
                           </span>
                           <span class="rating-value">3</span>
                           <input class=""  type="checkbox" ng-click="filterRating()" name = "rating[]" data-ng-model='query[searchBy]' ng-true-value='3'  ng-false-value=''/>
                           </a>
                        </li>
                        <li><a href="#">
                           <span>
                           <span class="rating-icon"><i class="fas fa-star"></i></span>
                           </span>
                           <span class="rating-value">4</span>
                           <input class=""  type="checkbox" ng-click="filterRating()" name = "rating[]" data-ng-model='query[searchBy]' ng-true-value='4'  ng-false-value=''/>
                           </a>
                        </li>
                        <li><a href="#">
                           <span>
                           <span class="rating-icon"><i class="fas fa-star"></i></span>
                           </span>
                           <span class="rating-value">5</span>
                           <input class=""  type="checkbox" ng-click="filterRating()" name = "rating[]" data-ng-model='query[searchBy]' ng-true-value='5'  ng-false-value=''/>
                           </a>
                        </li>
                     </ul>
                  </div>
                  <div class="price">
                     <p>Hotel Price</p>
                     <div class="rangeBlock">
                        <div class="rangeInput">
                           <input type="text" class="js-input-from" id="minPrice" value="0" readonly />
                          
                           <input type="text" class="js-input-to" id="maxPrice" value="0" readonly />
                        </div>
                        <div class="range-slider"><input type="text" class="js-range-slider" id="price-slider" value="" /></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-9">
            <div class="top-section hotel-search">
               <div class="d-flex justify-content-between">
                  <div class="center-div">
                     <p class="title-para">{{$_GET['cityname']}}</p>
                     <p class="detail-para"><span>{{$_GET['checkIndate']}} to {{$_GET['checkOutDate']}} ({{$_GET['NoOfNights']}} NIGHTS)</span>  <span class="seprator">|</span> 1 ROOM <span class="seprator">|</span> {{$_GET['NoOfAdults']}}ADULTS </p>
                  </div>
                  <div class="right-div">
                     <a href="#" data-toggle="modal" data-target="#hotel-modify"><i class="fas fa-search"></i> <span class="modify-search">Modify Search</span></a>
                     <button class="filter-btn"><i class="fas fa-filter"></i></button>
                     <button class="sort-btn"><i class="fas fa-sort-amount-up"></i></button>
                  </div>
               </div>
            </div>
            <div class="hotel-head">
               <div class="sorted-by">Sort by:</div>
               <div class="sorte-inner">
               
                  <div class="sorted-star" ng-click="sortType = 'HotelSearchResult.HotelResults[0].StarRating'; sortReverse = !sortReverse">Star Ratinga</div>
                  <div class="sorted-price" ng-click="sortType = 'HotelSearchResult.HotelResults[0].Price.PublishedPriceRoundedOff'; sortReverse = !sortReverse">Price</div>
                 
               </div>
            </div>
            <div class="hotel-body" >
            
               <div class="hotel-body-main" ng-repeat="(key,hotel) in HotelSearchResult.HotelResults | orderBy:orderProperty | orderBy:sortType:sortReverse |filter:query">
                 
                  <div class="hotel-image-box" >
                  <img ng-src="@{{hotel.HotelPicture}}" altSrc="{{asset('public/images/no-image.jpg')}}" onerror="this.src = $(this).attr('altSrc')">
                  
                  </div>
                  <div class="hotel-inner">
                     <div class="hotel-content">
                        <div class="hotel-name">
                           <p>@{{hotel.HotelName}}</p>
                        </div>
                        <div class="hotel-rating">
                           <p ><i class="fas fa-star" ng-repeat="n in [] | range:hotel.StarRating"></i></p>
                        </div>
                        <div class="hotel-location">
                           <p><i class="fas fa-map-marker-alt"></i> @{{hotel.HotelAddress}}</p>
                        </div>
                        <div class="hotel-decription">
                           <p ng-if="hotel.HotelDescription.length < 450">@{{hotel.HotelDescription.length}}</p>
                           <p ng-else>@{{hotel.HotelDescription | limitTo: 450 }} {{ '...'}}</p>
                        </div>
                     </div>
                     <div class="hotel-price">
                        <div class="hotel-main-price">
                           <p> @{{priceDisplay(hotel.Price.OfferedPriceRoundedOff)}}</p>
                        </div>
                        <div class="hotel-book-days">
                           <p>For {{$_GET['NoOfNights']}} nights</p>
                        </div>
                        <div class="hotel-book-btn">
                           
                           <a href="javascript:void(0);" class="book-btn" ng-click="viewdetail(hotel.ResultIndex,hotel.HotelCode,HotelSearchResult.TraceId,'{{$_SERVER['QUERY_STRING']}}');" >Choose Room</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="modal fade" id="hotel-modify" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Modify Search</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
         </div>
         <div class="modal-body">
            <form method = "get" >
               <div class="row">
                  <div class="col-md-6 form-group">
                     <input type="text" placeholder="Select Place" class="form-control hotel-place" value = "{{$_GET['cityname']}}" id = "cityList">
                     <input type = "hidden" name = "cityname" value = "{{$_GET['cityname']}}">
                     <input type = "hidden" name = "cityid" value = "{{$_GET['cityid']}}">
                      <input type = "hidden" name = "countryid" value = "{{$_GET['countryid']}}">
                  </div>
                  <div class="col-md-3 form-group">
                     <div class="input-group" id = "date_up">
                        <input type ="text" class="dateHidden form-control" name = "checkIndate" value="{{$_GET['checkIndate']}}" id = "depart_date"/>
                        <a href="javascript:void(0);" id="modelchooseDateBtn" class="prodDetBtngreen activegreen"><i class="far fa-calendar-alt"></i></a>
                        <div class="choosedatepicker">
                           <div id="modeldepartdate" style="display:none;"></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 form-group">
                     <div class="input-group" id = "date_down">
                        <input type ="text" class="dateHidden form-control" name = "checkOutDate" value="{{$_GET['checkOutDate']}}"  id = "return_date"/>
                        <input type = "hidden" id = "numberOfNight" name = "NoOfNights" value = "{{$_GET['NoOfNights']}}">
                        <a href="javascript:void(0);" id="modelchooseDateBtn1" class="prodDetBtngreen activegreen"><i class="far fa-calendar-alt"></i></a>
                        <div class="choosedatepicker">
                           <div id="modelreturndate" style="display:none;"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group ">
                  <div class= "row after-add-more">
                  <div class="col-md-12">
                     <label>Room 1 :</label>
                  </div>
                  <div class="col-md-4 mar-bottom">
                     <div class="value-inc"><button class="minus modelminus"  data-type="adultminus">-</button>
                        <span class="inputblock"><input name="NoOfAdults[]" id="tour_adult_count" type="text" value="1"> Adult<br>(above 12 years)</span>
                        <button class="plus modelplus"  data-type="adultplus">+</button>
                     </div>
                  </div>
                  <div class="col-md-4 mar-bottom">
                     <div class="value-inc"><button class="minus modelminus" data-type="childminus">-</button>
                        <span class="inputblock"><input name="NoOfChild[]" id="tour_child_count"  type="text" value="0"> Children<br>(below 12 years)</span>
                        <button class="plus modelplus" data-type="childplus">+</button>
                     </div>
                     <div class="tour-content age"> <span class="inputblock">Child Age </span></div>
                  </div>
                
                </div>
                  <div class="col-md-12">
                     <div class="add-row"><a href="#" class="under-link modeladd-more">Add another room</a> <a href="#" class="under-link modelremove" style = "display:none">Remove room</a>  </div>
                     
                  </div>

               </div>
               <div class="row form-group">
                  <div class="col-md-12">
                     <div class="flight-Bbtn"><button type = "submit" class = "billBtn" id = "hoteldetail">Search</button></div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection