/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
(function ($) {
    function toggleIcon(e)
    {
        $(e.target).prev().find('.more-less').toggleClass('fa-plus-square fa-minus-square');
    }

    $('.collapsable-extras').on('hidden.bs.collapse', toggleIcon);
    $('.collapsable-extras').on('shown.bs.collapse', toggleIcon);
})(jQuery);
