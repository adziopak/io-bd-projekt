package com.example.gloxiak.menu;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;


import com.manuelpeinado.imagelayout.ImageLayout;

import org.w3c.dom.Text;

import uk.co.senab.photoview.PhotoViewAttacher;


public class SearchActivity extends AppCompatActivity {
    TextView textView3;
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        //double posX = 0.32;
        //double posY = 0.44;
        double posX = 0.44;
        double posY = 0.70;
        double mapWidth = 1150;
        double mapHeight = 1750;


        ImageLayout imageLayout = (ImageLayout)findViewById(R.id.activity_search);
        ImageView imgVwv = new ImageView(this);
        ImageLayout.LayoutParams layoutParams = new ImageLayout.LayoutParams();
        layoutParams.right = (int)(mapWidth * posX);
        layoutParams.centerY = (int)(mapHeight * posY);
        imgVwv.setImageResource(R.drawable.marker);
        PhotoViewAttacher photoView= new PhotoViewAttacher(imgVwv);
        photoView.update();
        imageLayout.addView(imgVwv, layoutParams);
    }
}

