<?php

/**
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class File extends Object {

//    public static function arrayToCSVDownload($array, $filename = 'export', $delimiter = ';') {
//        // open raw memory as file so no temp files needed, you might run out of memory though
//        $f = fopen('php://memory', 'w');
//        // loop over the input array
//        foreach ($array as $line) {
//            // generate csv lines from the inner arrays
//            fputcsv($f, $line, $delimiter);
//        }
//        // reset the file pointer to the start of the file
//        fseek($f, 0);
//        // tell the browser it's going to be a csv file
//        header('Content-Type: application/csv');
//        // tell the browser we want to save it instead of displaying it
//        header('Content-Disposition: attachment; filename="' . $filename . '.csv";');
//        // make php send the generated csv lines to the browser
//        fpassthru($f);
//        return;
//    }

    public static function arrayToCSVDownload($input_array, $output_file_name = 'export', $delimiter = ';') {
        /** open raw memory as file, no need for temp files */
        $temp_memory = fopen('php://memory', 'w');
        
        /** loop through array */
        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($temp_memory, $line, $delimiter);
        }
        
        /** rewrind the "file" with the csv lines * */
        fseek($temp_memory, 0);

        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '.csv";');

        /** Send file to browser for download */
        return fpassthru($temp_memory);
    }

}
