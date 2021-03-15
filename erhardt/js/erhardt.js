/**
 * @file
 * Controls sections of the My LINCS (user profile) area.
 */

(function ($, Drupal) {
  Drupal.behaviors.erhardtcustom = {
    attach: function (context, settings) {
      $(document).ready(function () {
        Tipped.create('#tooltip', 'Some tooltip text');
      });
    }
  };
})(jQuery, Drupal);
