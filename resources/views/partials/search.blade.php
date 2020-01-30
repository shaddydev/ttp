<div class="tab-content">
   <div id="flight" class="tab-pane fade active show">
      <form action="{{url('flights')}}" method="get" >
         <div class="row no-gutters d-flex align-items-center">
            <div class="col-md-2 form-group">
               <input autocomplete="off" type="text" name = "start" placeholder="From" class="airport_list_up form-control" id = "origin" required>
               <input type = "hidden" name="origin">
               <input type = "hidden" name = "oct">
            </div>
            <div class="col-md-2 form-group">
               <input autocomplete="off" type="text" name = "end" placeholder="To" class="airport_list_down form-control" id = "destination" required>
               <input type = "hidden" name = "destination" >
               <input type = "hidden" name = "dct">
            </div>
            <div class="col-md-2 form-group">
               <div class="input-group">
                  <input autocomplete="off"  data-date-format="dd/mm/yyyy" name="date_up" class="datepicker form-control" id="depart_date" placeholder="Depart Date" data-provide="datepicker" value = "<?php echo date('d-M-Y' , strtotime(' +1 day'));?>">
                  <div class="input-group-addon">
                     <i class="fas fa-calendar-alt"></i>
                  </div>
               </div>
            </div>
            <div class="col-md-2 form-group">
               <div class="input-group">
                  <input type="text" autocomplete="off" data-date-format="dd/mm/yyyy" name="date_down" class="datepicker form-control" id="return_date" placeholder="Return Date" data-provide="datepicker" >
                  <div class="input-group-addon">
                     <i class="fas fa-calendar-alt"></i>
                  </div>
               </div>
            </div>
            <div class="col-md-2 form-group">
               <div id="tour-count">
                  <div class="tourist-val"><span class="tour-count-val">1</span><span> Traveller</span></div>
                  <div class="tour-icon"><i class="fas fa-caret-down"></i></div>
               </div>
               <div class="touriests_count">
                  <div class="tour-content">
                     <span class="inputblock"><input name="adult" id="adult_count" type="text" value="1"/> Adult</span>
                     <div class="signs">
                        <span class="minus" id="adult_minus">-</span>
                        <span class="plus" id="adult_plus">+</span>
                     </div>
                  </div>
                  <div class="tour-content">
                     <span class="inputblock"><input name="child" id="child_count" type="text" value="0"/> Child</span>
                     <div class="signs">
                        <span class="minus" id="child_minus">-</span>
                        <span class="plus" id="child_plus">+</span>
                     </div>
                  </div>
                  <div class="tour-content">
                     <span class="inputblock"><input name="infant" id="infant_count" type="text" value="0"/> Infant<br />(below 2 years)</span>
                     <div class="signs">
                        <span class="minus" id="infant_minus">-</span>
                        <span class="plus" id="infant_plus">+</span>
                     </div>
                  </div>
                  <span id = "msgbox" style = "color:red"></span>
                  <div class="tour-content">
                     <div class="custom-control custom-radio">
                        <input type="radio" checked class="custom-control-input" value="2" id="economy" name="cabin_class">
                        <label class="custom-control-label" for="economy">Economy</label>
                     </div>
                     <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" value="3" id="premiumeconomy" name="cabin_class">
                        <label class="custom-control-label" for="premiumeconomy">Premium Economy</label>
                     </div>
                     <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" value="4" id="business" name="cabin_class">
                        <label class="custom-control-label" for="business">Business</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-2 form-group">
               <div class="custom-control custom-checkbox">
                  <input name="isdirect" type="checkbox" class="custom-control-input" id="nonStop">
                  <label class="custom-control-label" for="nonStop">Non Stop Flight</label>
               </div>
            </div>
            <div class="col-md-12 text-center">
            @if (Auth::guest())
            <a href="{{url('login')}}" class="btn primary-btn">Login</a>
            @else
            <button class="primary-btn">search</button>
            @endif
            </div>
         </div>
      </form>
   </div>
   <div id="hotel" class="tab-pane fade">
      <form method = "get"  >
         <div class="row no-gutters d-flex align-items-center">
            <div class="col-md-4 form-group">
               <input type="text" placeholder="Select City, Location or Hotel Name" class="form-control hotel-place" id = "cityList">
               <input type = "hidden" name = "cityid">
               <input type = "hidden" name = "countryid">
            </div>
            <div class="col-md-3 form-group">
               <div class="input-group">
                  <input type="text" name="checkIndate" data-date-format="dd/mm/yyyy"  class="datepicker form-control" id="checkIndate" placeholder="Depart Date" data-provide="datepicker">
                  <div class="input-group-addon">
                     <i class="fas fa-calendar-alt"></i>
                  </div>
               </div>
            </div>
            <div class="col-md-3 form-group">
               <div class="input-group">
                  <input type="text" class="form-control" id="checkOutdate" placeholder="Check Out Date" name = "checkOutDate">
                  <input type = "hidden" id = "numberOfNight" name = "NoOfNights">
                  <input type = "hidden" name = "cityname">
                  <div class="input-group-addon">
                     <i class="fas fa-calendar-alt"></i>
                  </div>
               </div>
            </div>
            <div class="col-md-2 form-group ">
               <div id="tour-count1" class = "">
                  <div class="tourist-val"><span class="hotel-count-val" id = "people">1</span><span>Traveler</span></div>
                  <div class="tour-icon"><i class="fas fa-caret-down"></i></div>
               </div>
               <div class="touriests_count1 after-add-more">
                  <div class="tour-content1 control-group">
                     <div class="room-no">Room 1:</div>
                     <div class="tour-content">
                        <span class="inputblock"><input name="NoOfAdults[]" id="tour_adult_count" type="text" value="1"/> Adult</span>
                        <div class="signs">
                           <span class="minus aminus" data-type="adultminus">-</span>
                           <span class="plus aplus" data-type="adultplus">+</span>
                        </div>
                     </div>
                     <div class="tour-content">
                        <span class="inputblock"><input name="NoOfChild[]" id="tour_child_count" type="text" value="0"/> Child</span>
                        <div class="signs">
                           <span class="minus aminus" data-type="childminus">-</span>
                           <span class="plus aplus" data-type="childplus">+</span>
                        </div>
                     </div>
                    
                  </div>
                  <div class="add-del-room"><a href="javaScript:void(0)"class="hoteladdRoom add-more">Add room</a></div>
                  <div class="be-ddn-footer"><a href="#">Done</a></div>
                     <div class="copy-fields hide">
                     <!-- Add more field  -->
                        
                     </div>
               </div>
            </div>
            <div class="col-md-12 text-center">
            @if (Auth::guest())
            <a href="{{url('login')}}" class="btn primary-btn">Login</a>
            @else
            <button class="primary-btn" id = "hoteldetail"  type = "submit">search</button>
            <!-- <a href="javascript:void();" class="btn primary-btn">search</a> -->

            @endif
           
            </div>
         </div>
      </form>
   </div>
   <div id="bus" class="tab-pane fade">
      <form>
         <div class="row no-gutters d-flex align-items-center">
            <div class="col-md-3 form-group">
               <input type="text" placeholder="From" class="form-control">
            </div>
            <div class="col-md-3 form-group">
               <input type="text" placeholder="To" class="form-control">
            </div>
            <div class="col-md-3 form-group">
               <div class="input-group">
                  <input type="text" class="form-control" id="departdate" placeholder="Depart Date" >
                  <div class="input-group-addon">
                     <i class="fas fa-calendar-alt"></i>
                  </div>
               </div>
            </div>
            <div class="col-md-3 form-group">
               <div class="bus-seats">
                  <span class="inputblock"><input name="child" id="seat_count" type="text" value="1"/> Seat</span>
                  <div class="signs">
                     <span class="minus" id="seat_minus">-</span>
                     <span class="plus" id="seat_plus">+</span>
                  </div>
               </div>
            </div>
            <div class="col-md-12 text-center">
            @if (Auth::guest())
            <a href="{{url('login')}}" class="btn primary-btn">Login</a>
            @else
             <!--<button class="primary-btn">search</button>-->
             <a href="javascript:void();" class="btn primary-btn">search</a>
            @endif
            </div>
         </div>
      </form>
   </div>
</div>