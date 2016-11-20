<div class="container">
    <div class="row">
        <div class="col-sm-6 ftleft_col">
            <h3 class="box-title">Name</h3>
            <ul class="list-unstyled">
                <li><i class="fa fa-map-marker"></i> <span>{{trans('front.address')}}</span>: {{Option::get('i_address')}}</li>
                <li><i class="fa fa-phone"></i> <span>{{trans('front.phone')}}</span>: <a class="txt-strong" href="tel:{{Option::get('i_phone')}}">{{Option::get('i_phone')}}</a></li>
                <li><i class="fa fa-facebook-square"></i> <span>{{trans('front.facebook')}}</span>: <a href="{{Option::get('i_facebook')}}" target="_blank">{{Option::get('i_facebook')}}</a></li>
                <li><i class="fa fa-envelope"></i> <span>{{trans('front.email')}}</span>: <a href="mailto:{{Option::get('i_email')}}">{{Option::get('i_email')}}</a></li>
            </ul>
        </div>
        <div class="col-sm-6 ftright_col text-right">
            <div class="socials">
            </div>
            <div class="copyright">
                <p>Copyright <i class="fa fa-copyright"></i> 2016 nharapminhdung.com. All right reserved</p>
                <p>Designed by <a target="_blank" href="https://web.facebook.com/skyfrost.07">Pinla</a></p>
            </div>
        </div>
    </div>
</div>



