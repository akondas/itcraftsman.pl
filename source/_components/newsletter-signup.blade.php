<div class="flex justify-center lg:-mx-12 p-6 bg-grey-lighter border border-grey-light text-sm md:rounded shadow">
    <!-- Begin Mailchimp Signup Form -->
    <div id="mc_embed_signup" class="text-center">
        <form action="https://itcraftsman.us7.list-manage.com/subscribe/post?u=b8fa64b8b33c5d5d41ef8c0f0&amp;id=8c8cbe37f3" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <div id="mc_embed_signup_scroll">
                <h2>Zapisz się do newslettera</h2>
                <div class="mc-field-group">
                    <label for="mce-EMAIL">Adres e-mail </label>
                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Adres e-mail">
                </div>
                <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
                </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_25582686a9fc051afd5453557_189578c854" tabindex="-1" value=""></div>
                <div class="clear"><input type="submit" value="Zapisz mnie" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
            </div>
        </form>
    </div>
    <!--End Mailchimp Signup Form -->
</div>

@push('scripts')
    <script src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
    <script>(function($) {
        window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);
    </script>
@endpush
