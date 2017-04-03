package com.example.gloxiak.menu;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ImageView;

import uk.co.senab.photoview.PhotoViewAttacher;

public class MapActivity extends AppCompatActivity {
    ImageView imageView6;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);
        imageView6 = (ImageView)findViewById(R.id.imageView6);
        PhotoViewAttacher photoView= new PhotoViewAttacher(imageView6);
        photoView.update();
    }
}
