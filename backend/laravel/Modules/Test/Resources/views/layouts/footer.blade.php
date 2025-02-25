<div id="footer">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">@lang('messages.pdf_footer'): </span>
    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" class="pdf-image-footer">
</div>