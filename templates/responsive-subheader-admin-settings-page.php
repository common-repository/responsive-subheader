<?php
// Disable direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

  if(class_exists('ResponsiveSubheader'))
    $cRSSettings = new ResponsiveSubheader();

  $aFiles  = $cRSSettings->rs_get_imagefiles_from_dir();
  $aSubheaderSettings['sChosen'] = ( count( $cRSSettings->rs_get_overlay_img_option() ) ) ? $cRSSettings->rs_get_overlay_img_option() : '';
  $aSubheaderSettings['sFpColor']  = $cRSSettings->rs_get_subheader_fp_bg_color();
  $aSubheaderSettings['sColor']  = $cRSSettings->rs_get_subheader_bg_color();
  $aSubheaderSettings['iMaxWidth'] = $cRSSettings->rs_get_subheader_max_width();
  $aSubheaderSettings['bDisplayTitle'] = $cRSSettings->rs_get_display_page_title();
?>
<div class="wrap">
  <?php /* ADD PAGE ICON HERE */ ?>
  <h2 class="responsive-subheader-settings-page-title">Responsive Subheader Image Settings</h2>
  <p>Choose the background color for your subheader image section and the image file you want to use as the overlay on your sub-pages (pages that are not your front-page).</p>
  <form action="options.php" method="POST" class="responsive-subheader-settings-form">
    <?php settings_fields( 'rs-overlay-img-opts' ) ?>
    <?php do_settings_sections( 'rs-overlay-img-opts' ); ?>
    <table class="rs-overlay-settings-table">
      <tr>
        <td>
          <strong>Choose the background color for your <strong>Front Page</strong> subheader</strong>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" class="color-picker" id="rs_subheader_fp_bg_color" name="rs_subheader_fp_bg_color" value="<?php echo $aSubheaderSettings['sFpColor']; ?>" data-default-color="#1e73be" />
        </td>
      </tr>
      <tr>
        <td>
          <strong>Choose the background color for your <strong>page</strong> subheaders</strong>
        </td>
      </tr>
      <tr>
        <td>
          <input type="text" class="color-picker" id="rs_subheader_bg_color" name="rs_subheader_bg_color" value="<?php echo $aSubheaderSettings['sColor']; ?>" data-default-color="#1e73be" />
        </td>
      </tr>
      <tr>
        <td>
          <strong>Set the max width in pixels of the subheader image (up to the full width of your content container)</strong>
        </td>
      </tr>
      <tr>
        <td>
          <input type="number" class="" id="rs_subheader_max_width" name="rs_subheader_max_width" value="<?php echo $aSubheaderSettings['iMaxWidth']; ?>" data-max-width="1920" />px
        </td>
      </tr>
      <tr>
        <td>
          <strong>Display the Page Title on the Subheader</strong>
        </td>
      </tr>
      <tr>
        <td>
          <input type="radio" name="rs_display_page_title" value="0" <?php echo (!$aSubheaderSettings['bDisplayTitle']) ? ' checked="checked"' : ''; ?> /> No
          <input type="radio" name="rs_display_page_title" value="1" <?php echo ($aSubheaderSettings['bDisplayTitle']) ? ' checked="checked"' : ''; ?> /> Yes
        </td>
      </tr>
      <tr>
        <td>

          <?php submit_button(); ?>

        </td>
      </tr>
    </table>
    <p><strong>Choose an overlay style for your page subheaders:</strong></p>
    <table class="rs-overlay-settings-table">
      <thead>
        <tr>
        <th>Image Filename</th>
        <th colspan="2">Image</th>
        </tr>
      </thead>
      <tfoot>
        <th>Image Filename</th>
        <th colspan="2">Image</th>
      </tfoot>
      <tbody>
        <?php
          if(is_array($aFiles))
          {
            $iI = 1;
            foreach($aFiles as $sFile)
            {
              $sChecked   = ( !empty($aSubheaderSettings['sChosen']) && $aSubheaderSettings['sChosen'] === $sFile  ) ? ' checked ' : '';
              $sTableRow  = "\n<tr";
              $sTableRow .= (isset($sChecked) && $sChecked === ' checked ') ? ' style="background-color:rgb(235,255,224)"' : '' ;
              $sTableRow .= "><td>";
              $sTableRow .= $sFile.'</td>';
              // Input for image file and file to be displayed
              $sTableRow .= '<td><input type="radio" id="rs_overlay_img'.$iI.'" name="rs_overlay_img" value="'.$sFile.'" '.$sChecked.' /></td>';
              $sTableRow .= '
                <td class="rs-overlay-display-cell">
                    <label for="rs_overlay_img'.$iI.'">
                      <div class="subheader-container"';
              $sTableRow .= (!empty($aSubheaderSettings['sColor'])) ? ' style="background-color:'.$aSubheaderSettings['sColor'].'">' : '>';
              $sTableRow .= '
                          <div class="sub-header-banner-container">
                            <img src="'.RS_PLACEHOLDERS.'bg2.png" alt="placeholder image '.$iI.'" class="" />
                          </div>';

              $sTableRow .= '
                          <div class="rs_overlay_container overlay-visible">
                            <img src="'.RS_OVERLAYS.$sFile.'" alt="'.$sFile.'" />
                          </div>';

              $sTableRow .= '
                          <span class="rs_page_title_demo">Page Title Demo</span>
                      </div>
                    </label>';
              $sTableRow .= '</td></tr>';

              echo $sTableRow;
              $iI++;
            }
          }


        ?>
      </tbody>
    </table>
    <?php submit_button(); ?>
  </form>
</div>
