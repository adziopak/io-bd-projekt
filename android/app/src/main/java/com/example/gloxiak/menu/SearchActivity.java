package com.example.gloxiak.menu;

import android.content.res.Resources;
import android.graphics.drawable.Drawable;
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
        int mapWidth = 1150;
        int mapHeight = 1750;
        textView3=(TextView)findViewById(R.id.textView9);
        Bundle extras = getIntent().getExtras();
        if(extras!=null) {

            double posX = extras.getInt("positionX");
            double posY = extras.getInt("positionY");;
            String s = extras.getString("img");
            textView3.setText(s);
            String newString=s.replace(".png","");
            Resources res=getResources();
            int resID=res.getIdentifier(newString,"drawable", getPackageName());
            Drawable drawable = res.getDrawable(resID);

            ImageLayout imageLayout = (ImageLayout)findViewById(R.id.activity_search);

            imageLayout.setImageResource(resID, mapWidth, mapHeight);
            ImageView imgVwv = new ImageView(this);

            ImageLayout.LayoutParams layoutParams = new ImageLayout.LayoutParams();
            layoutParams.right = (int)(mapWidth * posX);
            layoutParams.centerY = (int)(mapHeight * posY);
           // imgVwv.setImageResource(R.drawable.marker);
            PhotoViewAttacher photoView= new PhotoViewAttacher(imgVwv);
            photoView.update();
            imageLayout.addView(imgVwv, layoutParams);
        }else textView3.setText("ERROR");





    }
}

