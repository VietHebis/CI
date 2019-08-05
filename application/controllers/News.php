<?php 
/**
* 
*/
class News extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }

    public function news_list()
	{
		$this->load->model('view_model');
		$news_list = $this->view_model->get_list();
	}

	public function view()
    {
        $id = $this->uri->segment(3);
        $id = intval($id);
        $info_news = $this->news_model->get_info($id);
        if (!$info_news)
        {
            redirect();
        }
        $this->data['info_news'] = $info_news;
        $view_count = $info_news->count_view + 1;
        $data_view = array(
            'count_view' => $view_count
        );
        $this->news_model->update($id,$data_view);
        $this->data['temp'] = 'site/news/index';
        $this->load->view('site/layout',$this->data);
    }
}
 ?>