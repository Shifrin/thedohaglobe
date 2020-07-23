<?php

// download_url() depends on it
require_once(ABSPATH . 'wp-admin/includes/file.php');
// wp_generate_attachment_metadata() depends on it
require_once(ABSPATH . 'wp-admin/includes/image.php');
// include "class-oembed.php" in order to use oEmbed API
require_once (ABSPATH . 'wp-includes/class-wp-oembed.php');

/**
 * Class VideoThumbnailGenerator.
 *
 * Automatically generate thumbnail for the added video.
 */
class VideoThumbnailGenerator
{
    public function __construct()
    {
        do_action('save_post', [$this, 'generateThumbnail'], 10, 2);
    }
    
    protected function download($postID, $url, $timeout = 600, $verification = false)
    {
        $tmpFile   = download_url($url, $timeout, $verification);
        $uploadDir = wp_upload_dir(date('Y/m'));
        $filePath  = $uploadDir['path'] . '/' . uniqid($postID . '_video_thumbnail_');

        copy($tmpFile, $filePath);
        unlink($tmpFile);

        return $filePath;
    }

    protected function setAsFeaturedImage($postID, $attachID)
    {
        set_post_thumbnail($postID, $attachID);
    }

    protected function insertAsAttachment($file, $postID)
    {
        $file = basename($file);
        // get mime type
        $fileType = wp_check_filetype($file, null);
        // prepare an array of post data for the attachment.
        $attachment = [
            'guid'           => $file,
            'post_mime_type' => $fileType['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', $file),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ];
        // insert the attachment.
        $attachID = wp_insert_attachment($attachment, $file, $postID);
        // Generate the metadata for the attachment, and update the database record.
        $metaData = wp_generate_attachment_metadata($attachID, $file);
        // update meta data
        wp_update_attachment_metadata($attachID, $metaData);

        // set the image as featured image
        $this->setAsFeaturedImage($postID, $attachID);
    }

    protected function getThumbnail($url)
    {
        $oembed = new WP_oEmbed();
        $provider = $oembed->discover($url);
        $video = $oembed->fetch($provider, $url);

        return isset($video->thumbnail_url) ? $video->thumbnail_url : null;
    }

    protected function validateUrl($url)
    {
        return strpos('http', $url) === 0;
    }

    public function generateThumbnail($postID, $post)
    {
        if (has_post_thumbnail($postID)) {
            return;
        }

        if ($post instanceof WP_Post) {
            $url  = $post->post_content;

            if (!$this->validateUrl($url)) {
                return;
            }

            $thumbnail = $this->getThumbnail($url);

            if ($thumbnail !== null) {
                $file = $this->download($postID, $url);

                $this->insertAsAttachment($file, $postID);
            }
        }
    }
}

new VideoThumbnailGenerator();