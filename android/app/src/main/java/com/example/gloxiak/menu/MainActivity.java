package com.example.gloxiak.menu;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.widget.SearchView;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.w3c.dom.Text;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

     Button[] buttons = new Button[10];

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        
        
        buttons[3]= (Button) findViewById(R.id.button3);
        buttons[2] = (Button) findViewById(R.id.button2);
          Context mContext = this;
        int checkExistence = mContext.getResources().getIdentifier("v1" , "drawable", mContext.getPackageName());
        if ( checkExistence != 0 ) 
        {  // the resouce exists...
            buttons[3].setVisibility(View.VISIBLE);
        }
        else 
        { 
            buttons[3].setVisibility(View.INVISIBLE);
        }
        checkExistence = mContext.getResources().getIdentifier("p", "drawable", mContext.getPackageName());
        if ( checkExistence != 0 )
        {  // the resouce exists...
            buttons[2].setVisibility(View.VISIBLE);
        }
        else 
        {
            buttons[2].setVisibility(View.INVISIBLE);

        }
        
        buttons[3].setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent newAct = new Intent(MainActivity.this, BuildingActivity.class);
                startActivity(newAct);
            }
        });
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);

        SearchView sv = (SearchView) findViewById(R.id.searchViewNav);
        sv.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            public boolean onQueryTextSubmit(String query) {
                Intent newAct = new Intent(MainActivity.this, JsonActivity.class);
                Bundle b = new Bundle();
                b.putString("query", query);
                newAct.putExtras(b);
                startActivity(newAct);
                return true;
            }

            public boolean onQueryTextChange(String newText) {
                return false;
            }
        });
        return true;
    }


    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        if (id == R.id.nav_buildings) {
            Intent op1 = new Intent(MainActivity.this, SearchActivity.class);
            startActivity(op1);
        } else if (id == R.id.nav_navigation) {
            Intent op2 = new Intent(MainActivity.this, MapsActivity.class);
            startActivity(op2);
        } else if (id == R.id.nav_map) {
            Intent op3 = new Intent(MainActivity.this, MapActivity.class);
            startActivity(op3);

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
