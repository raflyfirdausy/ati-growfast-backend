<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

// $lang['form_validation_required']		= 'The {field} field is required.';
// $lang['form_validation_isset']			= 'The {field} field must have a value.';
// $lang['form_validation_valid_email']		= 'The {field} field must contain a valid email address.';
// $lang['form_validation_valid_emails']		= 'The {field} field must contain all valid email addresses.';
// $lang['form_validation_valid_url']		= 'The {field} field must contain a valid URL.';
// $lang['form_validation_valid_ip']		= 'The {field} field must contain a valid IP.';
$slang['form_validation_valid_base64']        = 'The {field} field must contain a valid Base64 string.';
// $lang['form_validation_min_length']		= 'The {field} field must be at least {param} characters in length.';
// $lang['form_validation_max_length']		= 'The {field} field cannot exceed {param} characters in length.';
// $lang['form_validation_exact_length']		= 'The {field} field must be exactly {param} characters in length.';
// $lang['form_validation_alpha']			= 'The {field} field may only contain alphabetical characters.';
// $lang['form_validation_alpha_numeric']		= 'The {field} field may only contain alpha-numeric characters.';
// $slang['form_validation_alpha_numeric_spaces']    = 'The {field} field may only contain alpha-numeric characters and spaces.';
// $lang['form_validation_alpha_dash']		= 'The {field} field may only contain alpha-numeric characters, underscores, and dashes.';
// $lang['form_validation_numeric']		= 'The {field} field must contain only numbers.';
// $lang['form_validation_is_numeric']		= 'The {field} field must contain only numeric characters.';
// $lang['form_validation_integer']		= 'The {field} field must contain an integer.';
// $lang['form_validation_regex_match']		= 'The {field} field is not in the correct format.';
// $lang['form_validation_matches']		= 'The {field} field does not match the {param} field.';
$slang['form_validation_differs']        = 'The {field} field must differ from the {param} field.';
// $lang['form_validation_is_unique'] 		= 'The {field} field must contain a unique value.';
// $lang['form_validation_is_natural']		= 'The {field} field must only contain digits.';
// $lang['form_validation_is_natural_no_zero']	= 'The {field} field must only contain digits and must be greater than zero.';
// $lang['form_validation_decimal']		= 'The {field} field must contain a decimal number.';
// $lang['form_validation_less_than']		= 'The {field} field must contain a number less than {param}.';
$slang['form_validation_less_than_equal_to']    = 'The {field} field must contain a number less than or equal to {param}.';
// $lang['form_validation_greater_than']		= 'The {field} field must contain a number greater than {param}.';
$slang['form_validation_greater_than_equal_to']    = 'The {field} field must contain a number greater than or equal to {param}.';
$slang['form_validation_error_message_not_set']    = 'Unable to access an error message corresponding to your field name {field}.';
$slang['form_validation_in_list']        = 'The {field} field must be one of: {param}.';


$lang['form_validation_required']   = "Kolom %s harus diisi.";
$lang['form_validation_isset']    = "Kolom %s harus memiliki nilai.";
$lang['form_validation_valid_email']  = "Kolom %s harus berisi alamat email yang valid.";
$lang['form_validation_valid_emails']  = "Kolom %s harus berisi semua alamat email yang valid.";
$lang['form_validation_valid_url']   = "Kolom %s harus berisi URL yang valid.";
$lang['form_validation_valid_ip']   = "Kolom %s harus berisi IP yang valid.";
$lang['form_validation_min_length']   = "Kolom %s harus setidaknya %s karakter.";
$lang['form_validation_max_length']   = "Kolom %s tidak dapat melebihi %s karakter.";
$lang['form_validation_exact_length']  = "Kolom %s harus tepat %s karakter.";
$lang['form_validation_alpha']    = "Kolom %s hanya dapat berisi karakter abjad.";
$lang['form_validation_alpha_numeric']  = "Kolom %s hanya dapat berisi karakter alpha-numeric.";
$lang['form_validation_alpha_numeric_spaces']    = 'Kolom %s hanya dapat berisi karakter alpha-numeric dan spasi.';
$lang['form_validation_alpha_dash']   = "Kolom %s hanya dapat berisi alpha-numeric karakter , garis bawah , dan garis.";
$lang['form_validation_numeric']   = "Kolom %s harus berisi angka saja.";
$lang['form_validation_is_numeric']   = "Kolom %s harus berisi karakter numerik.";
$lang['form_validation_integer']   = "Kolom %s harus berisi sebuah integer.";
$lang['form_validation_regex_match']  = "Kolom %s tidak dalam format yang benar.";
$lang['form_validation_matches']   = "Kolom %s tidak cocok Kolom %s.";
$lang['form_validation_is_unique']    = "%s sudah terdaftar di database.";
$lang['form_validation_is_natural']   = "Kolom %s harus berisi hanya angka positif.";
$lang['form_validation_is_natural_no_zero'] = "Kolom %s harus berisi angka lebih besar dari nol.";
$lang['form_validation_decimal']   = "Kolom %s harus berisi angka desimal.";
$lang['form_validation_less_than']   = "Kolom %s harus berisi angka kurang dari %s.";
$lang['form_validation_greater_than']  = "Kolom %s harus berisi jumlah yang lebih besar dari %s.";
