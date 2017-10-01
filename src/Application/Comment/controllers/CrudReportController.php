<?php

namespace App\Comment\controllers;

use App\Comment\models\ReportModel;
use App\Libraries\RouterAware;

use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;
use System\Controller\CrudController;

class CrudReportController extends CrudController
{
  /**
   * @var string
   */
  protected $viewPath = "@comment/admin/reports";

  /**
   * @var string
   */
  protected $prefixName = "Admin#Comments";

  /**
   * @var string
   */
  protected $prefixChapters = "Front#Chapters";


  public function __construct(RendererInterface $renderer, Router $router, ReportModel $model)
  {
    // Idratation 
    parent::__construct($renderer, $router, $model);
  }

  /**
  * CREATE new report
  */
  public function create (Request $request)
  {
    if ($request->getMethod() === 'POST') {

      // Step 1: Recovery only of the desired keys.
      $datas = $this->getParams($request);
      
      if (!empty($datas['report_lvl']) && in_array($datas['report_lvl'], [1,2,3])) {
        // Step 2: Creating report.
        $this->model->create($datas);
      }

    }
    // Step 3: Redirection to the original page.
    return $this->redirect($this->prefixChapters . '#One',[
      'slugBook'       => $request->getAttribute('slugBook'),
      'chapters_order' => $request->getAttribute('chapters_order'),
      'slugChapter'    => $request->getAttribute('slugChapter')
    ]);

  }

  /**
  * DELETE one element
  */
  public function delete (Request $request)
  { 
    $comment = $request->getAttribute('id');

    // Step 2 : Find all reports of comment and delete them
    $commentReports = $this->model->findAllBy('comments_id',$comment);
    foreach ($commentReports as $report) {
      $this->model->delete($report);
    }

    // Step 2: Redirection to the original page.
    return $this->redirect($this->prefixName . '#Read');
  }

  /**
  * Filter to recover only of the desired keys.
  */
  protected function getParams (Request $request)
  {
    // Step 1: Filter
    $datas =  array_filter($request->getParsedBody(), function ($key) {
        return in_array($key, ['report_lvl','comments_id']);
      }, ARRAY_FILTER_USE_KEY);

    return $datas;

  }

}
