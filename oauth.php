<?php 
	try{
		// ![수정필요] 카카오 API 환경설정 파일 
		include_once "/config.php";
        // include_once "../DB/db_connection.php";
		// 기본 응답 설정
		$res = array('rst'=>'fail','code'=>(__LINE__*-1),'msg'=>'');

		// code && state 체크
		if( empty($_GET['code']) || empty($_GET['state']) ||  $_GET['state'] != $_COOKIE['state']){ throw new Exception("인증실패", (__LINE__*-1) );}

		// 토큰 요청
		$replace = array(
			'{grant_type}'=>'authorization_code',
			'{client_id}'=>$kakaoConfig['client_id'],
			'{redirect_uri}'=>$kakaoConfig['redirect_uri'],
			'{client_secret}'=>$kakaoConfig['client_secret'],
			'{code}'=>$_GET['code']
		);
		$login_token_url = str_replace(array_keys($replace), array_values($replace), $kakaoConfig['login_token_url']);
		$token_data = json_decode(curl_kakao($login_token_url));
		if( empty($token_data)){ throw new Exception("토큰요청 실패", (__LINE__*-1) ); }
		if( !empty($token_data->error) || empty($token_data->access_token) ){ 
			throw new Exception("토큰인증 에러", (__LINE__*-1) ); 
		}


		// 프로필 요청 
		$header = array("Authorization: Bearer ".$token_data->access_token);
		$profile_url = $kakaoConfig['profile_url'];
		$profile_data = json_decode(curl_kakao($profile_url,$header));

		if( empty($profile_data) || empty($profile_data->id) ){ throw new Exception("프로필요청 실패", (__LINE__*-1) ); }
       	
		// 최종 성공 처리
		$res['rst'] = 'success';
        echo "success";
	}catch(Exception $e){
		if(!empty($e->getMessage())){ $res['msg'] = $e->getMessage(); }
		if(!empty($e->getMessage())){ $res['code'] = $e->getCode(); }
	}


	// // 성공처리
	// if($res['rst'] == 'success'){
    //     // header("Location:https://grad.kw.ac.kr/");
	// }

	// // 실패처리 
	// else{
	// }

	// // state 초기화 
	// setcookie('state','',time()-3000); // 300 초동안 유효

    // // index 페이지 이동
        
	exit;