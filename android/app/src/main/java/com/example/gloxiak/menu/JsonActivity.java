package com.example.gloxiak.menu;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.support.v7.app.AppCompatActivity;
import android.content.Intent;
import android.os.Bundle;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;
import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;

public class JsonActivity extends AppCompatActivity
{
    HttpHandler sh = new HttpHandler();
    private String TAG = JsonActivity.class.getSimpleName();
    private ListView lvMap, lvPin;

    private String[] urlTabMap = {"http://skkshowcase.cba.pl/android/map?name=V", "http://skkshowcase.cba.pl/android/map?name=P",
            "http://skkshowcase.cba.pl/android/map?name=J", "http://skkshowcase.cba.pl/android/map?name=S"};

    private String[] urlTabPin = {"http://skkshowcase.cba.pl/android/sendPins?name=V", "http://skkshowcase.cba.pl/android/sendPins?name=P",
            "http://skkshowcase.cba.pl/android/sendPins?name=J", "http://skkshowcase.cba.pl/android/sendPins?name=S"};

    private int h = 0, w = 0;
    private String urlMap = urlTabMap[h];
    private String urlPin = urlTabPin[w];

    ArrayList<HashMap<String, String>> dataListMap;
    ArrayList<HashMap<String, String>> dataListPin;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_json);

        dataListMap = new ArrayList<>();
        dataListPin = new ArrayList<>();

        lvMap = (ListView) findViewById(R.id.list);
        lvPin = (ListView) findViewById(R.id.list);

        new GetData().execute();
    }

    private class GetData extends AsyncTask<Void, Void, Void>
    {

        @Override
        protected void onPreExecute()
        {
            super.onPreExecute();
        }

        protected ArrayList getMapData()
        {
            while (h < urlTabMap.length)
            {
                String jsonStrMap = sh.makeServiceCall(urlMap);
                Log.e(TAG, "Response from url: " + jsonStrMap);
                if (jsonStrMap != null) {
                    try {
                        JSONArray dataArrayMap = new JSONArray(jsonStrMap);
                        for (int i = 0; i < dataArrayMap.length(); i++) {
                            JSONObject jsonObjMap = dataArrayMap.getJSONObject(i);

                            //tutaj wdecydujemy co ma byc zapisywane do listy
                            String nameMap = jsonObjMap.getString("name");
                            HashMap<String, String> data_tmp_map = new HashMap<>();
                            data_tmp_map.put("name", nameMap);
                            dataListMap.add(data_tmp_map);

                        }
                        if (h < (urlTabMap.length)- 1)
                        {
                            urlMap = urlTabMap[h + 1];
                        }
                        h = h + 1;

                    } catch (final JSONException e) {
                        Log.e(TAG, "Json parsing error: " + e.getMessage());
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getApplicationContext(),
                                        "Json parsing error: " + e.getMessage(),
                                        Toast.LENGTH_LONG)
                                        .show();
                            }
                        });

                    }

                } else {
                    Log.e(TAG, "Couldn't get json from server.");
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Toast.makeText(getApplicationContext(),
                                    "Couldn't get json from server. Check LogCat for possible errors!",
                                    Toast.LENGTH_LONG)
                                    .show();
                        }
                    });

                }
            }
            return dataListMap;
        }

        protected ArrayList getPinData()
        {
            while(w < urlTabPin.length)
            {
                String jsonStrPin = sh.makeServiceCall(urlPin);
                Log.e(TAG, "Response from url: " + jsonStrPin);
                if (jsonStrPin != null) {
                    try {
                        JSONArray dataArrayPin = new JSONArray(jsonStrPin);
                        for (int j = 0; j < dataArrayPin.length(); j++) {
                            JSONObject jsonObjPin = dataArrayPin.getJSONObject(j);

                            //tutaj wdecydujemy co ma byc zapisywane do listy
                            String namePin = jsonObjPin.getString("name");
                            HashMap<String, String> data_tmp_Pin = new HashMap<>();
                            data_tmp_Pin.put("name", namePin);
                            dataListPin.add(data_tmp_Pin);

                        }
                        if (w < (urlTabPin.length) - 1)
                        {
                            urlPin = urlTabPin[w + 1];
                        }
                        w = w + 1;

                    } catch (final JSONException e) {
                        Log.e(TAG, "Json parsing error: " + e.getMessage());
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getApplicationContext(),
                                        "Json parsing error: " + e.getMessage(),
                                        Toast.LENGTH_LONG)
                                        .show();
                            }
                        });

                    }

                } else {
                    Log.e(TAG, "Couldn't get json from server.");
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            Toast.makeText(getApplicationContext(),
                                    "Couldn't get json from server. Check LogCat for possible errors!",
                                    Toast.LENGTH_LONG)
                                    .show();
                        }
                    });

                }
            }
            return dataListPin;
        }

        private boolean isNetworkAvailable(){
            ConnectivityManager connectivityManager
                    = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
            NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
            return activeNetworkInfo != null && activeNetworkInfo.isConnected();
        }

        @Override
        protected Void doInBackground(Void... arg0)
        {
            if (isNetworkAvailable())
            {
            getMapData();
            getPinData();
            }
            while (!isNetworkAvailable())
            {
                if (isCancelled());
                break;
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);

            if(!isNetworkAvailable())
                Toast.makeText(JsonActivity.this, "Nie udało się pobrać danych, brak połączenia z internetem", Toast.LENGTH_LONG).show();

            Intent main = new Intent(JsonActivity.this, MainActivity.class);
            startActivity(main);
            finish();
        }

    }
}


