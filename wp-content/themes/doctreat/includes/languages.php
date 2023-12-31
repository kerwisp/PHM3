<?php
/**
 * Languages
 *
 * @package doctreat
 */

if (!function_exists('doctreat_prepare_languages')) {

    function doctreat_prepare_languages() {
        $language_codes = array(
        'ab' => esc_html__('Abkhazian','doctreat'),
		'aa' => esc_html__('Afar','doctreat'),
		'zu' => esc_html__('Zulu','doctreat'),
		'af' => esc_html__('Afrikaans','doctreat'),
		'ak' => esc_html__('Akan','doctreat'),
		'sq' => esc_html__('Albanian','doctreat'),
		'am' => esc_html__('Amharic','doctreat'),
		'ar' => esc_html__('Arabic','doctreat'),
		'an' => esc_html__('Aragonese','doctreat'),
		'hy' => esc_html__('Armenian','doctreat'),
		'as' => esc_html__('Assamese','doctreat'),
		'av' => esc_html__('Avaric','doctreat'),
		'ae' => esc_html__('Avestan','doctreat'), 
		'ay' => esc_html__('Aymara','doctreat'),
		'az' => esc_html__('Azerbaijani','doctreat'),
		'bm' => esc_html__('Bambara','doctreat'),
		'ba' => esc_html__('Bashkir','doctreat'),
		'eu' => esc_html__('Basque','doctreat'),
		'be' => esc_html__('Belarusian','doctreat'),
		'bn' => esc_html__('Bengali','doctreat'),
		'bh' => esc_html__('Bihari languages','doctreat'),
		'bi' => esc_html__('Bislama','doctreat'),
		'bs' => esc_html__('Bosnian','doctreat'),
		'br' => esc_html__('Breton','doctreat'),
		'bg' => esc_html__('Bulgarian','doctreat'),
		'my' => esc_html__('Burmese','doctreat'),
		'ca' => esc_html__('Catalan, Valencian','doctreat'),
		'ct' => esc_html__('Catalan, Catalunya','doctreat'),
		'km' => esc_html__('Central Khmer','doctreat'),
		'ch' => esc_html__('Chamorro','doctreat'),
		'ce' => esc_html__('Chechen','doctreat'),
		'ny' => esc_html__('Chichewa, Chewa, Nyanja','doctreat'),
		'zh' => esc_html__('Chinese','doctreat'),
		'cu' => esc_html__('Church Slavonic, Old Bulgarian, Old Church Slavonic','doctreat'),
		'cv' => esc_html__('Chuvash','doctreat'),
		'kw' => esc_html__('Cornish','doctreat'),
		'co' => esc_html__('Corsican','doctreat'),
		'cr' => esc_html__('Cree','doctreat'),
		'hr' => esc_html__('Croatian','doctreat'),
		'cs' => esc_html__('Czech','doctreat'),
		'da' => esc_html__('Danish','doctreat'),
		'dv' => esc_html__('Divehi, Dhivehi, Maldivian','doctreat'),
		'nl' => esc_html__('Dutch, Flemish','doctreat'),
		'dz' => esc_html__('Dzongkha','doctreat'),
		'en' => esc_html__('English','doctreat'),
		'eo' => esc_html__('Esperanto','doctreat'),
		'et' => esc_html__('Estonian','doctreat'),
		'ee' => esc_html__('Ewe','doctreat'),
		'fo' => esc_html__('Faroese','doctreat'),
		'fj' => esc_html__('Fijian','doctreat'),
		'fi' => esc_html__('Finnish','doctreat'),
		'fr' => esc_html__('French','doctreat'),
		'ff' => esc_html__('Fulah','doctreat'),
		'gd' => esc_html__('Gaelic, Scottish Gaelic','doctreat'),
		'gl' => esc_html__('Galician','doctreat'),
		'lg' => esc_html__('Ganda','doctreat'),
		'ka' => esc_html__('Georgian','doctreat'),
		'de' => esc_html__('German','doctreat'),
		'ki' => esc_html__('Gikuyu, Kikuyu','doctreat'),
		'el' => esc_html__('Greek (Modern)','doctreat'),
		'kl' => esc_html__('Greenlandic, Kalaallisut','doctreat'),
		'gn' => esc_html__('Guarani','doctreat'),
		'gu' => esc_html__('Gujarati','doctreat'),
		'ht' => esc_html__('Haitian, Haitian Creole','doctreat'),
		'ha' => esc_html__('Hausa','doctreat'),
		'he' => esc_html__('Hebrew','doctreat'),
		'hz' => esc_html__('Herero','doctreat'),
		'hi' => esc_html__('Hindi','doctreat'),
		'ho' => esc_html__('Hiri Motu','doctreat'),
		'hu' => esc_html__('Hungarian','doctreat'),
		'is' => esc_html__('Icelandic','doctreat'),
		'io' => esc_html__('Ido','doctreat'),
		'ig' => esc_html__('Igbo','doctreat'),
		'id' => esc_html__('Indonesian','doctreat'),
		'ia' => esc_html__('Interlingua (International Auxiliary Language Association)','doctreat'),
		'ie' => esc_html__('Interlingue','doctreat'),
		'iu' => esc_html__('Inuktitut','doctreat'),
		'ik' => esc_html__('Inupiaq','doctreat'),
		'ga' => esc_html__('Irish','doctreat'),
		'it' => esc_html__('Italian','doctreat'),
		'ja' => esc_html__('Japanese','doctreat'),
		'jv' => esc_html__('Javanese','doctreat'),
		'kn' => esc_html__('Kannada','doctreat'),
		'kr' => esc_html__('Kanuri','doctreat'),
		'ks' => esc_html__('Kashmiri','doctreat'),
		'kk' => esc_html__('Kazakh','doctreat'),
		'rw' => esc_html__('Kinyarwanda','doctreat'),
		'kv' => esc_html__('Komi','doctreat'),
		'kg' => esc_html__('Kongo','doctreat'),
		'ko' => esc_html__('Korean','doctreat'),
		'kj' => esc_html__('Kwanyama, Kuanyama','doctreat'),
		'ku' => esc_html__('Kurdish','doctreat'),
		'ky' => esc_html__('Kyrgyz','doctreat'),
		'lo' => esc_html__('Lao','doctreat'),
		'la' => esc_html__('Latin','doctreat'),
		'lv' => esc_html__('Latvian','doctreat'),
		'lb' => esc_html__('Letzeburgesch, Luxembourgish','doctreat'),
		'li' => esc_html__('Limburgish, Limburgan, Limburger','doctreat'),
		'ln' => esc_html__('Lingala','doctreat'),
		'lt' => esc_html__('Lithuanian','doctreat'),
		'lu' => esc_html__('Luba-Katanga','doctreat'),
		'mk' => esc_html__('Macedonian','doctreat'),
		'mg' => esc_html__('Malagasy','doctreat'),
		'ms' => esc_html__('Malay','doctreat'),
		'ml' => esc_html__('Malayalam','doctreat'),
		'mt' => esc_html__('Maltese','doctreat'),
		'gv' => esc_html__('Manx','doctreat'),
		'mi' => esc_html__('Maori','doctreat'),
		'mr' => esc_html__('Marathi','doctreat'),
		'mh' => esc_html__('Marshallese','doctreat'),
		'ro' => esc_html__('Moldovan, Moldavian, Romanian','doctreat'),
		'mn' => esc_html__('Mongolian','doctreat'),
		'na' => esc_html__('Nauru','doctreat'),
		'nv' => esc_html__('Navajo, Navaho','doctreat'),
		'nd' => esc_html__('Northern Ndebele','doctreat'),
		'ng' => esc_html__('Ndonga','doctreat'),
		'ne' => esc_html__('Nepali','doctreat'),
		'se' => esc_html__('Northern Sami','doctreat'),
		'no' => esc_html__('Norwegian','doctreat'),
		'nb' => esc_html__('Norwegian Bokmål','doctreat'),
		'nn' => esc_html__('Norwegian Nynorsk','doctreat'),
		'ii' => esc_html__('Nuosu, Sichuan Yi','doctreat'),
		'oc' => esc_html__('Occitan (post 1500)','doctreat'),
		'oj' => esc_html__('Ojibwa','doctreat'),
		'or' => esc_html__('Oriya','doctreat'),
		'om' => esc_html__('Oromo','doctreat'),
		'os' => esc_html__('Ossetian, Ossetic','doctreat'),
		'pi' => esc_html__('Pali','doctreat'),
		'pa' => esc_html__('Panjabi, Punjabi','doctreat'),
		'ps' => esc_html__('Pashto, Pushto','doctreat'),
		'fa' => esc_html__('Persian','doctreat'),
		'pl' => esc_html__('Polish','doctreat'),
		'pt' => esc_html__('Portuguese','doctreat'),
		'qu' => esc_html__('Quechua','doctreat'),
		'rm' => esc_html__('Romansh','doctreat'),
		'rn' => esc_html__('Rundi','doctreat'),
		'ru' => esc_html__('Russian','doctreat'),
		'sm' => esc_html__('Samoan','doctreat'),
		'sg' => esc_html__('Sango','doctreat'),
		'sa' => esc_html__('Sanskrit','doctreat'),
		'sc' => esc_html__('Sardinian','doctreat'),
		'sr' => esc_html__('Serbian','doctreat'),
		'sn' => esc_html__('Shona','doctreat'),
		'sd' => esc_html__('Sindhi','doctreat'),
		'si' => esc_html__('Sinhala, Sinhalese','doctreat'),
		'sk' => esc_html__('Slovak','doctreat'),
		'sl' => esc_html__('Slovenian','doctreat'),
		'so' => esc_html__('Somali','doctreat'),
		'st' => esc_html__('Sotho, Southern','doctreat'),
		'nr' => esc_html__('South Ndebele','doctreat'),
		'es' => esc_html__('Spanish, Castilian','doctreat'),
		'su' => esc_html__('Sundanese','doctreat'),
		'sw' => esc_html__('Swahili','doctreat'),
		'ss' => esc_html__('Swati','doctreat'),
		'sv' => esc_html__('Swedish','doctreat'),
		'tl' => esc_html__('Tagalog','doctreat'),
		'ty' => esc_html__('Tahitian','doctreat'),
		'tg' => esc_html__('Tajik','doctreat'),
		'ta' => esc_html__('Tamil','doctreat'),
		'tt' => esc_html__('Tatar','doctreat'),
		'te' => esc_html__('Telugu','doctreat'),
		'th' => esc_html__('Thai','doctreat'),
		'bo' => esc_html__('Tibetan','doctreat'),
		'ti' => esc_html__('Tigrinya','doctreat'),
		'to' => esc_html__('Tonga (Tonga Islands)','doctreat'),
		'ts' => esc_html__('Tsonga','doctreat'),
		'tn' => esc_html__('Tswana','doctreat'),
		'tr' => esc_html__('Turkish','doctreat'),
		'tk' => esc_html__('Turkmen','doctreat'),
		'tw' => esc_html__('Twi','doctreat'),
		'ug' => esc_html__('Uighur, Uyghur','doctreat'),
		'uk' => esc_html__('Ukrainian','doctreat'),
		'ur' => esc_html__('Urdu','doctreat'),
		'uz' => esc_html__('Uzbek','doctreat'),
		've' => esc_html__('Venda','doctreat'),
		'vi' => esc_html__('Vietnamese','doctreat'),
		'vo' => esc_html__('Volap_k','doctreat'),
		'wa' => esc_html__('Walloon','doctreat'),
		'cy' => esc_html__('Welsh','doctreat'),
		'fy' => esc_html__('Western Frisian','doctreat'),
		'wo' => esc_html__('Wolof','doctreat'),
		'xh' => esc_html__('Xhosa','doctreat'),
		'yi' => esc_html__('Yiddish','doctreat'),
		'yo' => esc_html__('Yoruba','doctreat'),
		'za' => esc_html__('Zhuang, Chuang','doctreat'),
		'zu' => esc_html__('Zulu','doctreat')
        );
		
		$language_codes	= apply_filters('doctreat_filter_langauges',$language_codes);
		
		return $language_codes;
    }

}