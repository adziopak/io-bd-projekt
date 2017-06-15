package com.example.gloxiak.menu;

import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ImageView;

public class LoadingActivity extends AppCompatActivity {

    private static int SPLASH_TIME_OUT = 3000;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_loading);

        ImageView imageView = (ImageView)findViewById(R.id.imageView7);
        imageView.setImageResource(R.drawable.politechnikalogo);
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                Intent home = new Intent(LoadingActivity.this, MainActivity.class);
                startActivity(home);
                finish();

                Intent json = new Intent(LoadingActivity.this, JsonActivity.class);
                startActivity(json);
                finish();
            }
        },SPLASH_TIME_OUT);


    }

}
