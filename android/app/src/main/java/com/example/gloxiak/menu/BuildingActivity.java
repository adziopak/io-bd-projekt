package com.example.gloxiak.menu;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ImageView;
import uk.co.senab.photoview.PhotoViewAttacher;


public class BuildingActivity extends AppCompatActivity {
    ImageView imageView;
    ImageView imageView2;
    ImageView imageView3;
    ImageView imageView4;
    ImageView imageView5;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_building);
        imageView = (ImageView)findViewById(R.id.imageView);
        PhotoViewAttacher photoView= new PhotoViewAttacher(imageView);
        imageView2 = (ImageView)findViewById(R.id.imageView2);
        PhotoViewAttacher photoView2= new PhotoViewAttacher(imageView2);
        imageView3 = (ImageView)findViewById(R.id.imageView3);
        PhotoViewAttacher photoView3= new PhotoViewAttacher(imageView3);
        imageView4 = (ImageView)findViewById(R.id.imageView4);
        PhotoViewAttacher photoView4= new PhotoViewAttacher(imageView4);
        imageView5 = (ImageView)findViewById(R.id.imageView5);
        PhotoViewAttacher photoView5= new PhotoViewAttacher(imageView5);
        photoView.update();
        photoView2.update();
        photoView3.update();
        photoView4.update();
        photoView5.update();
    }
}
