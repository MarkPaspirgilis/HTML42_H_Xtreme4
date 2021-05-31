var XtremeGallery = function (xpath) {
    if (typeof window.jQuery != 'undefined' && typeof window.$ != 'undefined') {
        this.elements = {
            $root: {length:0},
            $images: {length:0}
        };
        this.data = {};
        var $xpath = $(xpath);
        if(typeof xpath != 'undefined' && $xpath.length >= 0) {
            this.elements.$root = $xpath;
            this.init();
        } else {
            console.error('XtremeGallery::ERROR::xpath is not valid DOM-Element', xpath);
        }
    } else {
        console.error('XtremeGallery::ERROR::jQuery is not loaded.');
    }
};
XtremeGallery.prototype.init = function () {
    var _this = this;
    this.data = this.elements.$root.data('xtreme-gallery');
    this.elements.$root.attr('data-xtreme-gallery', 'done');
    $(this.data).each(function() {
        if(typeof this.image == 'string') {
            var image_name = this.image.split('/');
            image_name = image_name[image_name.length - 1];
            var image_name_clean = image_name.split('.')[0];
            //
            var item_name = (typeof this.name == 'string' ? this.name : null);
            var item_description = (typeof this.description == 'string' ? this.description : null);
            if(!item_name) {
                item_name = image_name_clean;
            }
            //
            var img = document.createElement('img');
            img.src = this.image;
            var $imgwrap = $('<div class="xg_item" />');
            $imgwrap.append([
                img,
                '<div class="xg_item_name">' + item_name + '</div>',
                item_description ? '<div class="xg_item_description">' + item_description + '</div>' : item_description
            ]);
            _this.elements.$root.append($imgwrap);
        }
    });
};
