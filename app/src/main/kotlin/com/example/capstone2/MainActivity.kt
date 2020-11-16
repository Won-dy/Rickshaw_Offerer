package com.example.capstone2

import android.app.Activity
import android.content.ContentValues.TAG
import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.*
import com.android.volley.Response
import com.android.volley.toolbox.Volley
import com.kakao.sdk.auth.LoginClient
import com.kakao.sdk.auth.model.OAuthToken
import com.kakao.sdk.common.model.AuthErrorCause
import com.kakao.sdk.user.UserApiClient
import kr.co.ilg.activity.login.BusinessLicenseConfirmActivity
import kr.co.ilg.activity.login.FindPasswordInfoActivity
import kr.co.ilg.activity.login.Sharedpreference
import org.json.JSONObject

class MainActivity : Activity() {
    lateinit var context: Context

    init{
        instance = this
    }

    companion object {
        private var instance: com.example.capstone2.MainActivity? = null
        fun applicationContext() : Context {
            return instance!!.applicationContext
        }
    }
    lateinit var myJSON : String;

    override fun onCreate(savedInstanceState: Bundle?)
    {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.login);


        Sharedpreference.clear(applicationContext)
        val idET = findViewById<EditText>(R.id.idET);
        val pwET = findViewById<EditText>(R.id.pwET);
        val kakaoLoginBtn = findViewById<ImageButton>(R.id.kakaoLoginBtn)

        val loginBtn = findViewById<Button>(R.id.loginBtn)
        val findPwBtn = findViewById<TextView>(R.id.findPwBtn)
        val signUpBtn = findViewById<TextView>(R.id.signUpBtn)


        fun intent(){
            var intent = Intent(this, kr.co.ilg.activity.findwork.MainActivity::class.java)
            startActivity(intent) // 일반로그인 정보갖고오기
        }
        fun signup(email: String){
            var intent1 = Intent(application, BusinessLicenseConfirmActivity::class.java)
            Sharedpreference.set_kakaoemail(applicationContext,"kakaoemail",email);
            startActivity(intent1)
        }


        val callback: (OAuthToken?, Throwable?) -> Unit = { token, error ->
            if (error != null) {
                when {
                    error.toString() == AuthErrorCause.AccessDenied.toString() -> {
                        Toast.makeText(this, "접근이 거부 됨(동의 취소)", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.InvalidClient.toString() -> {
                        Toast.makeText(this, "유효하지 않은 앱", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.InvalidGrant.toString() -> {
                        Toast.makeText(this, "인증 수단이 유효하지 않아 인증할 수 없는 상태", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.InvalidRequest.toString() -> {
                        Toast.makeText(this, "요청 파라미터 오류", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.InvalidScope.toString() -> {
                        Toast.makeText(this, "유효하지 않은 scope ID", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.Misconfigured.toString() -> {
                        Toast.makeText(this, "설정이 올바르지 않음(android key hash)", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.ServerError.toString() -> {
                        Toast.makeText(this, "서버 내부 에러", Toast.LENGTH_SHORT).show()
                    }
                    error.toString() == AuthErrorCause.Unauthorized.toString() -> {
                        Toast.makeText(this, "앱이 요청 권한이 없음", Toast.LENGTH_SHORT).show()
                    }
                    else -> { // Unknown
                        Toast.makeText(this, "기타 에러", Toast.LENGTH_SHORT).show()
                    }
                }
            }
            else if (token != null) {
                UserApiClient.instance.me { user, error ->
                    if (error != null) {
                        Log.e(TAG, "사용자 정보 요청 실패", error)
                    }
                    else if (user != null) {
                        if (user.kakaoAccount?.email != null) {
                            Log.i(TAG, "이메일: ${user.kakaoAccount?.email}" +
                                    "\n닉네임: ${user.kakaoAccount?.profile?.nickname}")
                            val rListener: Response.Listener<String?> = object : Response.Listener<String?> {

                                override fun onResponse(response: String?) {
                                    try {
                                        val jResponse = JSONObject(response!!.substring(response!!.indexOf("{"), response!!.lastIndexOf("}") + 1))
                                        val isExistWorker = jResponse.getBoolean("tryLogin")
                                        if (isExistWorker) {  // 회원이 존재하면 로그인된 화면으로 넘어감
                                            var business_reg_num = jResponse.getString("business_reg_num")
                                            var manager_pw = jResponse.getString("manager_pw")
                                            var manager_represent_name = jResponse.getString("manager_represent_name")
                                            var manager_office_name = jResponse.getString("manager_office_name")
                                            var manager_office_telnum = jResponse.getString("manager_office_telnum")
                                            var manager_office_address = jResponse.getString("manager_office_address")
                                            var manager_name = jResponse.getString("manager_name")
                                            var local_code = jResponse.getString("local_code")
                                            var local_sido = jResponse.getString("local_sido")
                                            var local_sigugun = jResponse.getString("local_sigugun")
                                            var manager_phonenum = jResponse.getString("manager_phonenum")
                                            var manager_bankname = jResponse.getString("manager_bankname")
                                            var manager_office_info = jResponse.getString("manager_office_info")
                                            var manager_bankaccount = jResponse.getString("manager_bankaccount")


                                            Sharedpreference.set_business_reg_num(applicationContext(), "business_reg_num", business_reg_num)
                                            Sharedpreference.set_local_sido(applicationContext(), "local_sido", local_sido)
                                            Sharedpreference.set_local_sigugun(applicationContext(), "local_sigugun", local_sigugun)
                                            Sharedpreference.set_manager_pw(applicationContext(), "manager_pw", manager_pw)
                                            Sharedpreference.set_manager_represent_name(applicationContext(), "manager_represent_name", manager_represent_name)
                                            Sharedpreference.set_manager_office_name(applicationContext(), "manager_office_name", manager_office_name)
                                            Sharedpreference.set_manager_office_telnum(applicationContext(), "manager_office_telnum", manager_office_telnum)
                                            Sharedpreference.set_manager_office_address(applicationContext(), "manager_office_address", manager_office_address)
                                            Sharedpreference.set_manager_name(applicationContext(), "manager_name", manager_name)
                                            Sharedpreference.set_local_code(applicationContext(), "local_code", local_code)
                                            Sharedpreference.set_manager_phonenum(applicationContext(), "manager_phonenum", manager_phonenum)
                                            Sharedpreference.set_manager_bankname(applicationContext(), "manager_bankname", manager_bankname)
                                            Sharedpreference.set_manager_office_info(applicationContext(), "manager_office_info", manager_office_info)
                                            Sharedpreference.set_manager_bankaccount(applicationContext(), "manager_bankaccount", manager_bankaccount)// 파일에 맵핑형식으로 저장

                                            Toast.makeText(this@MainActivity, "로그인에 성공하였습니다.", Toast.LENGTH_SHORT).show()
                                            intent() //
                                            //Toast.makeText(FindPasswordInfoActivity.this, "등록된 "+worker_pw, Toast.LENGTH_SHORT).show();
                                        } else {  // 회원이 존재하지 않는다면
                                            Log.d("회원가입해야되영      ", isExistWorker.toString())

                                            signup(user.kakaoAccount?.email!!) // 회원가입 진행
                                        }
                                    } catch (e: Exception) {
                                        Log.d("mytest", e.toString())
                                    }

                                }
                            }
                            val lRequest = kr.co.ilg.activity.login.LoginRequest(user.kakaoAccount?.email, "0", rListener) // Request 처리 클래스
                            val queue = Volley.newRequestQueue(this) // 데이터 전송에 사용할 Volley의 큐 객체 생성

                            queue.add(lRequest) // Volley로 구현된 큐에 ValidateRequest 객체를 넣어둠으로써 실제로 서버 연동 발생
                        }
                        else if (user.kakaoAccount?.emailNeedsAgreement == false) {
                            Log.e(TAG, "사용자 계정에 이메일 없음.")
                            val rListener: Response.Listener<String?> = object : Response.Listener<String?> {

                                override fun onResponse(response: String?) {
                                    try {
                                        val jResponse = JSONObject(response!!.substring(response!!.indexOf("{"), response!!.lastIndexOf("}") + 1))
                                        val isExistWorker = jResponse.getBoolean("tryLogin")
                                        if (isExistWorker) {  // 회원이 존재하면 로그인된 화면으로 넘어감
                                            var business_reg_num = jResponse.getString("business_reg_num")
                                            var manager_pw = jResponse.getString("manager_pw")
                                            var manager_represent_name = jResponse.getString("manager_represent_name")
                                            var manager_office_name = jResponse.getString("manager_office_name")
                                            var manager_office_telnum = jResponse.getString("manager_office_telnum")
                                            var manager_office_address = jResponse.getString("manager_office_address")
                                            var manager_name = jResponse.getString("manager_name")
                                            var local_code = jResponse.getString("local_code")
                                            var local_sido = jResponse.getString("local_sido")
                                            var local_sigugun = jResponse.getString("local_sigugun")
                                            var manager_phonenum = jResponse.getString("manager_phonenum")
                                            var manager_bankname = jResponse.getString("manager_bankname")
                                            var manager_office_info = jResponse.getString("manager_office_info")
                                            var manager_bankaccount = jResponse.getString("manager_bankaccount")


                                            Sharedpreference.set_business_reg_num(applicationContext(), "business_reg_num", business_reg_num)
                                            Sharedpreference.set_local_sido(applicationContext(), "local_sido", local_sido)
                                            Sharedpreference.set_local_sigugun(applicationContext(), "local_sigugun", local_sigugun)
                                            Sharedpreference.set_manager_pw(applicationContext(), "manager_pw", manager_pw)
                                            Sharedpreference.set_manager_represent_name(applicationContext(), "manager_represent_name", manager_represent_name)
                                            Sharedpreference.set_manager_office_name(applicationContext(), "manager_office_name", manager_office_name)
                                            Sharedpreference.set_manager_office_telnum(applicationContext(), "manager_office_telnum", manager_office_telnum)
                                            Sharedpreference.set_manager_office_address(applicationContext(), "manager_office_address", manager_office_address)
                                            Sharedpreference.set_manager_name(applicationContext(), "manager_name", manager_name)
                                            Sharedpreference.set_local_code(applicationContext(), "local_code", local_code)
                                            Sharedpreference.set_manager_phonenum(applicationContext(), "manager_phonenum", manager_phonenum)
                                            Sharedpreference.set_manager_bankname(applicationContext(), "manager_bankname", manager_bankname)
                                            Sharedpreference.set_manager_office_info(applicationContext(), "manager_office_info", manager_office_info)
                                            Sharedpreference.set_manager_bankaccount(applicationContext(), "manager_bankaccount", manager_bankaccount)// 파일에 맵핑형식으로 저장

                                            intent() //
                                            //Toast.makeText(FindPasswordInfoActivity.this, "등록된 "+worker_pw, Toast.LENGTH_SHORT).show();
                                        } else {  // 회원이 존재하지 않는다면
                                            Log.d("회원가입해야되영      ", isExistWorker.toString())

                                            signup(user.id.toString()!!) // 회원가입 진행
                                        }
                                    } catch (e: Exception) {
                                        Log.d("mytest", e.toString())
                                    }

                                }
                            }
                            val lRequest = kr.co.ilg.activity.login.LoginRequest(user.id.toString(), "0", rListener) // Request 처리 클래스
                            val queue = Volley.newRequestQueue(this) // 데이터 전송에 사용할 Volley의 큐 객체 생성

                            queue.add(lRequest) // Volley로 구현된 큐에 ValidateRequest 객체를 넣어둠으로써 실제로 서버 연동 발생
                        }
                        else if (user.kakaoAccount?.emailNeedsAgreement == true) {
                            Log.d(TAG, "사용자에게 이메일 제공 동의를 받아야함.")

                            val scopes = listOf("account_email")
                            LoginClient.instance.loginWithNewScopes(this, scopes) { token, error ->
                                if (error != null) {
                                    Log.e(TAG, "이메일 제공 동의 실패", error)
                                } else {
                                    Log.d(TAG, "allowed scopes: ${token!!.scopes}")

                                    UserApiClient.instance.me { user, error ->
                                        if (error != null) {
                                            Log.e(TAG, "사용자 정보 요청 실패", error)
                                        }
                                        else if (user != null) {
                                            Log.i(TAG, "이메일: ${user.kakaoAccount?.email}" +
                                                    "\n닉네임: ${user.kakaoAccount?.profile?.nickname}")

                                            val rListener: Response.Listener<String?> = object : Response.Listener<String?> {

                                                override fun onResponse(response: String?) {
                                                    try {
                                                        val jResponse = JSONObject(response!!.substring(response!!.indexOf("{"), response!!.lastIndexOf("}") + 1))
                                                        val isExistWorker = jResponse.getBoolean("tryLogin")
                                                        if (isExistWorker) {  // 회원이 존재하면 로그인된 화면으로 넘어감

                                                            var business_reg_num = jResponse.getString("business_reg_num")
                                                            var manager_pw = jResponse.getString("manager_pw")
                                                            var manager_represent_name = jResponse.getString("manager_represent_name")
                                                            var manager_office_name = jResponse.getString("manager_office_name")
                                                            var manager_office_telnum = jResponse.getString("manager_office_telnum")
                                                            var manager_office_address = jResponse.getString("manager_office_address")
                                                            var manager_name = jResponse.getString("manager_name")
                                                            var local_code = jResponse.getString("local_code")
                                                            var local_sido = jResponse.getString("local_sido")
                                                            var local_sigugun = jResponse.getString("local_sigugun")
                                                            var manager_phonenum = jResponse.getString("manager_phonenum")
                                                            var manager_bankname = jResponse.getString("manager_bankname")
                                                            var manager_office_info = jResponse.getString("manager_office_info")
                                                            var manager_bankaccount = jResponse.getString("manager_bankaccount")


                                                            Sharedpreference.set_business_reg_num(applicationContext(), "business_reg_num", business_reg_num)
                                                            Sharedpreference.set_local_sido(applicationContext(), "local_sido", local_sido)
                                                            Sharedpreference.set_local_sigugun(applicationContext(), "local_sigugun", local_sigugun)
                                                            Sharedpreference.set_manager_pw(applicationContext(), "manager_pw", manager_pw)
                                                            Sharedpreference.set_manager_represent_name(applicationContext(), "manager_represent_name", manager_represent_name)
                                                            Sharedpreference.set_manager_office_name(applicationContext(), "manager_office_name", manager_office_name)
                                                            Sharedpreference.set_manager_office_telnum(applicationContext(), "manager_office_telnum", manager_office_telnum)
                                                            Sharedpreference.set_manager_office_address(applicationContext(), "manager_office_address", manager_office_address)
                                                            Sharedpreference.set_manager_name(applicationContext(), "manager_name", manager_name)
                                                            Sharedpreference.set_local_code(applicationContext(), "local_code", local_code)
                                                            Sharedpreference.set_manager_phonenum(applicationContext(), "manager_phonenum", manager_phonenum)
                                                            Sharedpreference.set_manager_bankname(applicationContext(), "manager_bankname", manager_bankname)
                                                            Sharedpreference.set_manager_office_info(applicationContext(), "manager_office_info", manager_office_info)
                                                            Sharedpreference.set_manager_bankaccount(applicationContext(), "manager_bankaccount", manager_bankaccount)// 파일에 맵핑형식으로 저장

                                                            intent() //
                                                            //Toast.makeText(FindPasswordInfoActivity.this, "등록된 "+worker_pw, Toast.LENGTH_SHORT).show();
                                                        } else {  // 회원이 존재하지 않는다면
                                                            Log.d("회원가입해야되영      ", isExistWorker.toString());

                                                            signup(user.kakaoAccount?.email!!) // 회원가입 진행
                                                        }
                                                    } catch (e: Exception) {
                                                        Log.d("mytest", e.toString())
                                                    }

                                                }
                                            }
                                            val lRequest = kr.co.ilg.activity.login.LoginRequest(user.kakaoAccount?.email, "0", rListener) // Request 처리 클래스
                                            val queue = Volley.newRequestQueue(this) // 데이터 전송에 사용할 Volley의 큐 객체 생성

                                            queue.add(lRequest) // Volley로 구현된 큐에 ValidateRequest 객체를 넣어둠으로써 실제로 서버 연동 발생
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        kakaoLoginBtn.setOnClickListener {
            /*if(LoginClient.instance.isKakaoTalkLoginAvailable(this)){
                LoginClient.instance.loginWithKakaoTalk(this, callback = callback)
            }else{*/
                LoginClient.instance.loginWithKakaoAccount(this, callback = callback)

        }

        loginBtn.setOnClickListener {
            val reg_num: String = idET.getText().toString()
            val manager_pw: String = pwET.getText().toString()
            val rListener: Response.Listener<String?> = object : Response.Listener<String?> {

                override fun onResponse(response: String?) {
                    try {
                        val jResponse = JSONObject(response!!.substring(response!!.indexOf("{"), response!!.lastIndexOf("}") + 1))
                        val isExistWorker = jResponse.getBoolean("tryLogin")
                        Log.d("=============", isExistWorker.toString());
                        if (isExistWorker) {  // 회원이 존재하면 로그인된 화면으로 넘어감

                            var business_reg_num = jResponse.getString("business_reg_num")
                            var manager_pw = jResponse.getString("manager_pw")
                            var manager_represent_name = jResponse.getString("manager_represent_name")
                            var manager_office_name = jResponse.getString("manager_office_name")
                            var manager_office_telnum = jResponse.getString("manager_office_telnum")
                            var manager_office_address = jResponse.getString("manager_office_address")
                            var manager_name = jResponse.getString("manager_name")
                            var local_code = jResponse.getString("local_code")
                            var local_sido = jResponse.getString("local_sido")
                            var local_sigugun = jResponse.getString("local_sigugun")
                            var manager_phonenum = jResponse.getString("manager_phonenum")
                            var manager_bankname = jResponse.getString("manager_bankname")
                            var manager_office_info = jResponse.getString("manager_office_info")
                            var manager_bankaccount = jResponse.getString("manager_bankaccount")


                            Sharedpreference.set_business_reg_num(applicationContext(), "business_reg_num", business_reg_num)
                            Sharedpreference.set_local_sido(applicationContext(), "local_sido", local_sido)
                            Sharedpreference.set_local_sigugun(applicationContext(), "local_sigugun", local_sigugun)
                            Sharedpreference.set_manager_pw(applicationContext(), "manager_pw", manager_pw)
                            Sharedpreference.set_manager_represent_name(applicationContext(), "manager_represent_name", manager_represent_name)
                            Sharedpreference.set_manager_office_name(applicationContext(), "manager_office_name", manager_office_name)
                            Sharedpreference.set_manager_office_telnum(applicationContext(), "manager_office_telnum", manager_office_telnum)
                            Sharedpreference.set_manager_office_address(applicationContext(), "manager_office_address", manager_office_address)
                            Sharedpreference.set_manager_name(applicationContext(), "manager_name", manager_name)
                            Sharedpreference.set_local_code(applicationContext(), "local_code", local_code)
                            Sharedpreference.set_manager_phonenum(applicationContext(), "manager_phonenum", manager_phonenum)
                            Sharedpreference.set_manager_bankname(applicationContext(), "manager_bankname", manager_bankname)
                            Sharedpreference.set_manager_office_info(applicationContext(), "manager_office_info", manager_office_info)
                            Sharedpreference.set_manager_bankaccount(applicationContext(), "manager_bankaccount", manager_bankaccount)

                            //Sharedpreference.set_Hope_local_sido(applicationContext(), "hope_local_sido", hope_local_sido)
                            //Sharedpreference.set_Hope_local_sigugun(applicationContext(), "hope_local_sigugun", hope_local_sigugun)// 파일에 맵핑형식으로 저장

                            intent() //
                            Toast.makeText(this@MainActivity, "로그인성공", Toast.LENGTH_SHORT).show();
                        } else {  // 회원이 존재하지 않는다면
                            Toast.makeText(this@MainActivity, "로그인실패", Toast.LENGTH_SHORT).show();
                        }
                    } catch (e: Exception) {
                        Log.d("mytest", e.toString())
                    }

                }
            }
            val lRequest = kr.co.ilg.activity.login.LoginRequest(reg_num, manager_pw, rListener) // Request 처리 클래스
            val queue = Volley.newRequestQueue(this) // 데이터 전송에 사용할 Volley의 큐 객체 생성

            queue.add(lRequest) // Volley로 구현된 큐에 ValidateRequest 객체를 넣어둠으로써 실제로 서버 연동 발생

        }
        findPwBtn.setOnClickListener {
            val intent = Intent(this, FindPasswordInfoActivity::class.java)
            startActivity(intent)
        }

        signUpBtn.setOnClickListener {
            val intent = Intent(this, BusinessLicenseConfirmActivity::class.java)
            startActivity(intent)
        }
    }



}