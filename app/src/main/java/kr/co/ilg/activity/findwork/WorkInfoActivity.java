package kr.co.ilg.activity.findwork;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Paint;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;
import com.example.capstone2.R;

import org.json.JSONObject;

import kr.co.ilg.activity.login.Sharedpreference;

public class WorkInfoActivity extends AppCompatActivity { //일자리 정보화면

    TextView title_tv,place_tv,office_info_tv,title_name_tv,job_tv,pay_tv,date_tv,time_tv,people_tv,contents_tv,address_tv;
    Button map_btn,rectify_btn,call_btn,message_btn;
    String jp_title, field_address, manager_office_name, job_name, jp_job_cost, jp_job_date, jp_job_start_time, jp_job_finish_time, jp_job_tot_people, jp_contents,business_reg_num,jp_num,field_name,jp_is_urgency, field_code, manager_phonenum;
    Context mContext;
    Intent intent;
    String mapAddress;
    WorkMapActivity workMapActivity = new WorkMapActivity();
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.work_info);

        mContext = this;
        address_tv = findViewById(R.id.address_tv);
        title_tv = findViewById(R.id.title_tv);
        place_tv = findViewById(R.id.place_tv);
        office_info_tv = findViewById(R.id.office_info_tv);
        title_name_tv = findViewById(R.id.title_name_tv);
        job_tv = findViewById(R.id.job_tv);
        pay_tv = findViewById(R.id.pay_tv);
        date_tv = findViewById(R.id.date_tv);
        time_tv = findViewById(R.id.time_tv);
        people_tv = findViewById(R.id.people_tv);
        contents_tv = findViewById(R.id.contents_tv);
        map_btn = findViewById(R.id.map_btn);
        rectify_btn = findViewById(R.id.rectify_btn);
        call_btn = findViewById(R.id.call_btn);
        message_btn = findViewById(R.id.message_btn);

       place_tv.setPaintFlags(place_tv.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
        office_info_tv.setPaintFlags(place_tv.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);

        Intent receiver = getIntent();
        jp_title = receiver.getExtras().getString("jp_title");
        field_address = receiver.getExtras().getString("field_address");
        mapAddress = field_address;
        manager_office_name = receiver.getExtras().getString("manager_office_name");
        job_name = receiver.getExtras().getString("job_name");
        jp_job_cost = receiver.getExtras().getString("jp_job_cost");
        jp_job_date = receiver.getExtras().getString("jp_job_date");
        jp_job_start_time = receiver.getExtras().getString("jp_job_start_time").substring(0,5);
        jp_job_finish_time = receiver.getExtras().getString("jp_job_finish_time").substring(0,5);
        jp_job_tot_people = receiver.getExtras().getString("jp_job_tot_people");
        jp_contents = receiver.getExtras().getString("jp_contents");
        business_reg_num = receiver.getExtras().getString("business_reg_num");
        jp_num = receiver.getExtras().getString("jp_num");
        field_name = receiver.getExtras().getString("field_name");
        jp_is_urgency = receiver.getExtras().getString("jp_is_urgency");
        field_code = receiver.getExtras().getString("field_code");

        title_tv.setText(jp_title);
        place_tv.setText(field_name);
        office_info_tv.setText(manager_office_name);
        title_name_tv.setText(jp_title);
        job_tv.setText(job_name);
        pay_tv.setText(jp_job_cost+"원");
        date_tv.setText(jp_job_date);
        time_tv.setText(jp_job_start_time+"~"+jp_job_finish_time);
        people_tv.setText(jp_job_tot_people+"명");
        contents_tv.setText(jp_contents);
        address_tv.setText(field_address);
        if(business_reg_num.equals(Sharedpreference.get_business_reg_num(mContext,"business_reg_num","managerinfo")))
        {

        }else
        {
            rectify_btn.setVisibility(View.INVISIBLE);
        }



        map_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(WorkInfoActivity.this, WorkMapActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra("mapAddress",mapAddress);
                intent.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);;
                startActivity(intent);
                Handler handler = new Handler();
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        workMapActivity.setMapCenter(mapAddress);
                    }
                }, 100); //딜레이 타임 조절 0.3초
            }
        });

        place_tv.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(WorkInfoActivity.this, FieldInfoActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra("field_code",field_code);
                intent.putExtra("field_name",field_name);
                intent.putExtra("field_address",field_address);
                startActivity(intent);
            }
        });

        office_info_tv.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(WorkInfoActivity.this, OfficeInfoActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra("business_reg_num", business_reg_num);
                startActivity(intent);
            }
        });

        rectify_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(WorkInfoActivity.this, WritePostingActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.putExtra("key","1");
                intent.putExtra("jp_num",jp_num);
                intent.putExtra("jp_title",jp_title);
                intent.putExtra("field_name",field_name);
                intent.putExtra("field_address",field_address);
                intent.putExtra("job_name",job_name);
                intent.putExtra("jp_job_cost",jp_job_cost);
                intent.putExtra("jp_job_tot_people",jp_job_tot_people);
                intent.putExtra("jp_job_date",jp_job_date);
                intent.putExtra("jp_job_start_time",jp_job_start_time);
                intent.putExtra("jp_job_finish_time",jp_job_finish_time);
                intent.putExtra("jp_contents",jp_contents);
                intent.putExtra("jp_is_urgency",jp_is_urgency);
                startActivity(intent);
            }
        });

        call_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Response.Listener rListener = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jResponse = new JSONObject(response.substring(response.indexOf("{"), response.lastIndexOf("}") + 1));
                            boolean selectTelNum = jResponse.getBoolean("selectTelNum");
                            if (selectTelNum) {
                                manager_phonenum = jResponse.getString("manager_phonenum");
                                Uri uri = Uri.parse("tel:" + manager_phonenum);
                                intent = new Intent(Intent.ACTION_DIAL, uri);
                                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                startActivity(intent);
                            } else {
                                Toast.makeText(WorkInfoActivity.this, "연락처 로드 실패", Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            Log.d("mytest", e.toString());
                        }
                    }
                };
                SelectTelNumRequest stnRequest = new SelectTelNumRequest(business_reg_num, rListener);

                RequestQueue queue = Volley.newRequestQueue(WorkInfoActivity.this);
                queue.add(stnRequest);
            }
        });

        message_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Response.Listener rListener = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jResponse = new JSONObject(response.substring(response.indexOf("{"), response.lastIndexOf("}") + 1));
                            boolean selectTelNum = jResponse.getBoolean("selectTelNum");
                            if (selectTelNum) {
                                manager_phonenum = jResponse.getString("manager_phonenum");
                                intent = new Intent(Intent.ACTION_SENDTO);
                                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                intent.putExtra("sms_body", "인력거 보고 연락드립니다.");
                                intent.setData(Uri.parse("smsto:" + Uri.encode(manager_phonenum)));
                                startActivity(intent);
                            } else {
                                Toast.makeText(WorkInfoActivity.this, "연락처 로드 실패", Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            Log.d("mytest", e.toString());
                        }
                    }
                };
                SelectTelNumRequest stnRequest = new SelectTelNumRequest(business_reg_num, rListener);

                RequestQueue queue = Volley.newRequestQueue(WorkInfoActivity.this);
                queue.add(stnRequest);
            }
        });
    }
}
