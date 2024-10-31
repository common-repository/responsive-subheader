<?php
// Disable direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

/**
 * Create Responsive Subheader template for html output
 */

if( $template_parts['subheader_display'] === true )
{
  // Get the max width of the banner container
  $iMaxWidth = get_option( 'rs_subheader_max_width' );

  // Set the html variable
  $html = '';

  switch($template_parts['subheader_type'])
  {
    /**
     * HTML template for responsive subheader output for frontpage
     */
    case 'frontpage':
      // Set boolean variable to control image container width if there is no text
      $bHasText = false;

      // Get the front page background color
      $sFpColor = get_option( 'rs_subheader_fp_bg_color' );

      // Set the html variable
      $html = '
          <div id="sub-header-wrapper" class="sub-header-front-page-wrapper" ';
      // Set the background color for the Front Page image/slider
      $html .= ( !empty($sFpColor) ) ? 'style="background-color: '.$sFpColor.';">' : '>';
      $html .= '
            <div class="sub-header-frontpage-container"';
      $html .= ( !empty( $iMaxWidth ) ) ? ' style="max-width:'.$iMaxWidth.'px;">' : '>';

      if(strlen($template_parts['subheader_content']) > 0) {
        $bHasText = true;
        $html .= '
               <span class="headpost-text-column">'.$template_parts['subheader_content'].'</span>';
        }

      // If there is no text inside the column then allow image to expand full width
      $html .= '
              <div class="headpost-thumb-column"';
      $html .= ( !$bHasText ) ? ' style="width:100%;">' : '>';

      $html .= $template_parts['subheader_thumb'] .

              '</div>

            </div><!-- sub-header-frontpage-container -->

          </div><!-- sub-header-wrapper -->
          <script>
            var NivoOptions = {
              sliderEffect: \'';
      // Set the slider effect if available else use the predetermined option
      $html .= ( isset( $template_parts['slider_effect'] ) ) ? $template_parts['slider_effect'] : "sliceDown";
      $html .= '\'
            };
          </script>';

    break;

    /**
     * HTML template for responsive subheader output for subpage
     */
    case 'page':
      // Get the overlay image
      $sOverlay = RS_OVERLAYS . get_option( 'rs_overlay_img' );
      $aOverlayParts = explode('/', $sOverlay);
      $sOverlayImgName = end($aOverlayParts);
      // Get the background color for the subheader
      $sColor = get_option( 'rs_subheader_bg_color' );
      $bDisplayTitle = get_option( 'rs_display_page_title' );

      // Set the html output
      $html = '
        <div id="sub-header-wrapper" class="sub-header-page-wrapper"';
      $html .= ( !empty( $iMaxWidth ) ) ? ' style="max-width:'.$iMaxWidth.'px;">' : '>';

      $html .= '
          <div id="sub-header" class="banner-container"';
      // Add background color if available
      $html .= ( !empty( $sColor ) ) ? ' style="background-color:'.$sColor.'">' : '>';
      $html .= '
            <div id="sub-header-banner-container">

            ' . $template_parts['subheader_thumb'] . '

            </div><!-- #sub-header-banner-container -->';

      // Add overlay if available
      if( !empty($sOverlayImgName) && $sOverlayImgName != 'rs-overlay-no-img.png' ) {
        $html .= '
              <div id="banner-overlay-container" class="visible-overlay">';

        if( !empty( $sColor )) {
          $html .= '
            <div class="visible-overlay-color-container"
            style="position:absolute;top:0;right:0;bottom:0;width:60%;background-color:'.$sColor.';z-index:4;">
              &nbsp;
            </div>';
        }

        $html .= '

                <img src="' . $sOverlay . '" alt="banner overlay" />

              </div><!-- #banner-overlay-container -->';
      }

      if( $bDisplayTitle ) :
      $html .= '
            <h2 class="page-title visible-title';
      $html .= ( !empty( $sColor ) ) ? ' rs-title-has-color" data-title-bgcolor="'.$sColor.'">' : '">';
      $html .= $template_parts['post_title'] . '</h2>';
      endif;

      $html .= '

          </div><!-- #sub-header -->

        </div><!-- #sub-header-wrapper -->';

    break;

    default:
      break;
  }

  // Output the html
  echo $html;

}

