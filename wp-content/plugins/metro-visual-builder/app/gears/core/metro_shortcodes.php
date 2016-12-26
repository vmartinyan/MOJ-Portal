<?php

class Metro_Shortcodes
{
    public $the_method = 'render';

    public function __construct( $_front_end_ajax_is_calling = false )
    {
        if( is_admin() && !$_front_end_ajax_is_calling )
            $this->the_method = 'admin_render';


        $this->_add_shortcode( 'mvb_recent_works', 'MVB_recent_works', $this->the_method);
        $this->_add_shortcode( 'mvb_recent_works_desc', 'MVB_Recent_Works_Desc', $this->the_method);

        $this->_add_shortcode( 'mvb_folio_carousel', 'MVB_Folio_Carousel', $this->the_method);

        $this->_add_shortcode( 'mvb_promo_row', 'MVB_Promo_Row', $this->the_method);

        $this->_add_shortcode( 'mvb_our_team', 'MVB_Our_Team', $this->the_method);

        $this->_add_shortcode( 'mvb_charts', 'MVB_Charts', $this->the_method);
        $this->_add_shortcode( 'mvb_chart', 'MVB_Charts', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_tiles', 'MVB_Tiles', $this->the_method);
        $this->_add_shortcode( 'mvb_tab', 'MVB_Tiles', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_recent_news', 'MVB_recent_news', $this->the_method);
        $this->_add_shortcode( 'mvb_featured_news', 'MVB_Featured_News', $this->the_method);
        $this->_add_shortcode( 'mvb_3_posts', 'MVB_3_Posts', $this->the_method);
        $this->_add_shortcode( 'mvb_4_posts', 'MVB_4_Posts', $this->the_method);
        $this->_add_shortcode( 'mvb_posts_carousel', 'MVB_Posts_Carousel', $this->the_method);

        $this->_add_shortcode( 'mvb_horizontal_skills', 'MVB_Horizontal_Skills', $this->the_method);
        $this->_add_shortcode( 'mvb_skill', 'MVB_Horizontal_Skills', 'repeater_'.$this->the_method);

       //$this->_add_shortcode( 'mvb_content', 'MVB_Content', $this->the_method);
        $this->_add_shortcode( 'mvb_timeline', 'MVB_Timeline', $this->the_method);

        $this->_add_shortcode( 'mvb_text', 'MVB_Text', $this->the_method);
		$this->_add_shortcode( 'mvb_text_image', 'MVB_Text_Image', $this->the_method);

        $this->_add_shortcode( 'mvb_video', 'MVB_Video', $this->the_method);

        $this->_add_shortcode( 'mvb_raw_html', 'MVB_Raw_HTML', $this->the_method);
        $this->_add_shortcode( 'mvb_raw_javascript', 'MVB_Raw_Javascript', $this->the_method);
        $this->_add_shortcode( 'mvb_shortcode', 'MVB_Shortcode', $this->the_method);

        $this->_add_shortcode( 'mvb_skills', 'MVB_Skills', $this->the_method);
        $this->_add_shortcode( 'mvb_skill', 'MVB_Skills', 'repeater_'.$this->the_method);
        $this->_add_shortcode( 'mvb_tabs', 'MVB_Tabs', $this->the_method);
        $this->_add_shortcode( 'mvb_tabs_list', 'MVB_Tabs_List', $this->the_method);
        $this->_add_shortcode( 'mvb_tab', 'MVB_Tabs', 'repeater_'.$this->the_method);
        $this->_add_shortcode( 'mvb_accordion', 'MVB_Accordion', $this->the_method);
        $this->_add_shortcode( 'mvb_accordion_panel', 'MVB_Accordion', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_gmaps', 'MVB_Gmaps', $this->the_method);
        $this->_add_shortcode( 'mvb_gmaps_address', 'MVB_Gmaps', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_testimonials', 'MVB_Testimonials', $this->the_method);
        $this->_add_shortcode( 'mvb_testimonial_user', 'MVB_Testimonials', 'repeater_'.$this->the_method);


        $this->_add_shortcode( 'mvb_image', 'MVB_Image', $this->the_method);


        $this->_add_shortcode( 'mvb_blog_posts', 'MVB_Blog_posts', $this->the_method);
        $this->_add_shortcode( 'mvb_blog_posts_1', 'MVB_Blog_posts_1', $this->the_method);
        $this->_add_shortcode( 'mvb_blog_posts_2', 'MVB_Blog_posts_2', $this->the_method);
        $this->_add_shortcode( 'mvb_blog_posts_3', 'MVB_Blog_posts_3', $this->the_method);

        $this->_add_shortcode( 'mvb_call_to_action', 'MVB_Call_To_Action', $this->the_method);
        //$this->_add_shortcode( 'mvb_service_description', 'MVB_Service_Description', $this->the_method);

        $this->_add_shortcode( 'mvb_clients', 'MVB_Clients', $this->the_method);
        $this->_add_shortcode( 'mvb_single_client', 'MVB_Clients', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_presentation_boxes', 'MVB_Presentation_Boxes', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box', 'MVB_Presentation_Boxes', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_presentation_boxes_vertical', 'MVB_Presentation_Boxes_Vertical', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_boxes_icon', 'MVB_Presentation_Boxes_Icon', $this->the_method);

        $this->_add_shortcode( 'mvb_presentation_boxes_img', 'MVB_Presentation_Boxes_Img', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box_img', 'MVB_Presentation_Boxes_Img', 'repeater_'.$this->the_method);

    }//end __construct();

    public function _add_shortcode( $shortcode, $the_class, $the_method )
    {
        global $mvb_metro_factory;
        add_shortcode( $shortcode, array($the_class, $the_method) );

        if( is_admin() )
        {
            $o_the_class = new $the_class;
            $mvb_metro_factory->add_shortcode( $the_class, $o_the_class->settings() );
        }//ednif;
    }//end _add_shortcode()

}// end class