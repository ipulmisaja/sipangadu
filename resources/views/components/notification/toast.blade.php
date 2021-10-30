<div class="position-fixed p-3 mr-3" style="z-index:5;bottom:5em;right:0;">
    <div
        x-data="{ show: false, message: '' }"
        x-on:notify.window="show = true; message = $event.detail; setTimeout(() => { show = false }, 3500)"
        x-show="show"
        x-description="Notification panel, show/hide based on alert state."
        id="liveToast"
        class="toast hide alert alert-primary"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-delay="2000">
        <div class="toast-header">
            <div class="d-flex alert-icon h6">
                <i class="far fa-lightbulb"></i>
                <strong class="ml-2 font-weight-bold">Notifikasi</strong>
            </div>
        </div>
        <div class="toast-body">
            <small x-text="message" class="font-weight-normal"></small>
        </div>
    </div>
</div>
