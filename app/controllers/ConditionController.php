<?php

class ConditionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Input::all();
		if ($data) {
			$resource = 'Condition';
			$table = 'issues';
			$table_primary_key = 'issue_id';
			$table_key = [
				'identifier' => 'issue_id',
				'subject' => 'subject',
				'encounter' => 'encounter',
				'dateAsserted' => 'issue_date_active',
				'code' => 'issue'
			];
			$result = $this->resource_translation($data, $table, $table_primary_key, $table_key);
			$table1 = 'assessment';
			$table1_primary_key = 'eid';
			$table1_key = [
				'identifier' => 'eid',
				'subject' => 'subject',
				'encounter' => 'encounter',
				'dateAsserted' => 'assessment_date',
				'code' => ['assessment_1','assessment_2','assessment_3','assessment_4','assessment_5','assessment_6','assessment_7','assessment_8','assessment_9','assessment_10','assessment_11','assessment_12']
			];
			$result1 = $this->resource_translation($data, $table1, $table1_primary_key, $table1_key);
			$count = 0;
			if ($result['response'] == true) {
				$count += $result['total'];
			}
			if ($result1['response'] == true) {
				$count += $result1['total'];
			}
			if ($count > 0) {
				$statusCode = 200;
				$time = date('c', time());
				$reference_uuid = $this->gen_uuid();
				$response['resourceType'] = 'Bundle';
				$response['title'] = 'Search result';
				$response['id'] = 'urn:uuid:' . $this->gen_uuid();
				$response['updated'] = $time;
				$response['category'][] = [
					'scheme' => 'http://hl7.org/fhir/tag',
					'term' => 'http://hl7.org/fhir/tag/message',
					'label' => 'http://ht7.org/fhir/tag/label'
				];
				$practice = DB::table('practiceinfo')->where('practice_id', '=', '1')->first();
				$response['author'][] = [
					'name' => $practice->practice_name,
					'uri' => route('home') . '/fhir'
				];
				$response['totalResults'] = $count;
				foreach ($result['data'] as $row_id) {
					$row = DB::table($table)->where($table_primary_key, '=', $row_id)->first();
					$resource_content = $this->resource_detail($row, $resource);
					$response['entry'][] = [
						'title' => 'Resource of type ' . $resource . ' with id = issue_id_' . $row_id . ' and version = 1',
						'link' => [
							'rel' => 'self',
							'href' => Request::url() . '/issue_id' . $row_id
						],
						'id' => Request::url() . '/issue_id_' . $row_id,
						'updated' => $time,
						'published' => $time,
						'author' => [
							'name' => $practice->practice_name,
							'uri' => route('home') . '/fhir'
						],
						'category' => [
							'scheme' => 'http://hl7.org/fhir/tag',
							'term' => 'http://hl7.org/fhir/tag/message',
							'label' => 'http://ht7.org/fhir/tag/label'
						],
						'content' => $resource_content,
						// the summary is variable
						//'summary' => '<div><h5>' . $row->lastname . ', ' . $row->firstname . '. MRN: ' . $row->pid . '</h5></div>'
					];
				}
				foreach ($result1['data'] as $row_id1) {
					$row1 = DB::table($table1)->where($table1_primary_key, '=', $row_id1)->first();
					$resource_content1 = $this->resource_detail($row1, $resource);
					$response['entry'][] = [
						'title' => 'Resource of type ' . $resource . ' with id = eid_' . $row_id1 . ' and version = 1',
						'link' => [
							'rel' => 'self',
							'href' => Request::url() . '/eid_' . $row_id1
						],
						'id' => Request::url() . '/eid_' . $row_id1,
						'updated' => $time,
						'published' => $time,
						'author' => [
							'name' => $practice->practice_name,
							'uri' => route('home') . '/fhir'
						],
						'category' => [
							'scheme' => 'http://hl7.org/fhir/tag',
							'term' => 'http://hl7.org/fhir/tag/message',
							'label' => 'http://ht7.org/fhir/tag/label'
						],
						'content' => $resource_content1,
						// the summary is variable
						//'summary' => '<div><h5>' . $row->lastname . ', ' . $row->firstname . '. MRN: ' . $row->pid . '</h5></div>'
					];
				}
			} else {
				$response = [
					'error' => "Query returned 0 records.",
				];
				$statusCode = 404;
			}
		} else {
			$response = [
				'error' => "Invalid query."
			];
			$statusCode = 404;
		}
		return Response::json($response, $statusCode);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}