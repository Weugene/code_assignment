jQuery( document ).on( 'input', 'input[data-setting="widget_id"]', function( $ ) {
    if (this.value.length > 20)
        console.log("Too long input widget id. It must be less than 20");
    this.maxLength = 20;
});
 