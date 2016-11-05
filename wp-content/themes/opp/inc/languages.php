<?php

// Get current language
$locale = pll_current_language();

// PO file translations
if ( file_exists( WP_LANG_DIR . '/themes/opp-fr_FR.mo' ) && $locale === 'fr' ) {
    load_textdomain( 'opp', WP_LANG_DIR . '/themes/opp-fr_FR.mo' );
}
