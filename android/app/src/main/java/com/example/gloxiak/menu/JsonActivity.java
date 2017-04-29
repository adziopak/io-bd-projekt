package com.example.gloxiak.menu;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class JsonActivity extends AppCompatActivity {


    private String TAG = JsonActivity.class.getSimpleName();

    private ProgressDialog pDialog;
    private ListView lv;

    // URL to get contacts JSON
    private static String url = "https://api.github.com/users/gloxiakx";

    ArrayList<HashMap<String, String>> dataList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_json);

        dataList = new ArrayList<>();

        lv = (ListView) findViewById(R.id.list);

        new GetData().execute();
    }

    /**
     * Async task class to get json by making HTTP call
     */
    private class GetData extends AsyncTask<Void, Void, Void> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            // Showing progress dialog
            pDialog = new ProgressDialog(JsonActivity.this);
            pDialog.setMessage("Please wait...");
            pDialog.setCancelable(false);
            pDialog.show();

        }

        @Override
        protected Void doInBackground(Void... arg0) {
            HttpHandler sh = new HttpHandler();

            // Making a request to url and getting response
            String jsonStr = sh.makeServiceCall(url);
            Log.e(TAG, "Response from url: " + jsonStr);

            if (jsonStr != null) {
                try {
                    JSONObject c = new JSONObject(jsonStr);

                    String login = c.getString("login");
                    String id = c.getString("id");
                    String avatar_url = c.getString("avatar_url");
                    String gravatar_id = c.getString("gravatar_id");
                    String url = c.getString("url");
                    String html_url = c.getString("html_url");
                    String followers_url = c.getString("followers_url");
                    String following_url = c.getString("following_url");
                    String gists_url = c.getString("gists_url");
                    String starred_url = c.getString("starred_url");
                    String subscriptions_url = c.getString("subscriptions_url");
                    String organizations_url = c.getString("organizations_url");
                    String repos_url = c.getString("repos_url");
                    String events_url = c.getString("events_url");
                    String received_events_url = c.getString("received_events_url");
                    String type = c.getString("type");
                    String site_admin = c.getString("site_admin");
                    String name = c.getString("name");
                    String company = c.getString("company");
                    String blog = c.getString("blog");
                    String location = c.getString("location");
                    String email = c.getString("email");
                    String hireable = c.getString("hireable");
                    String bio = c.getString("bio");
                    String public_repos = c.getString("public_repos");
                    String public_gists = c.getString("public_gists");
                    String followers = c.getString("followers");
                    String following = c.getString("following");
                    String created_at = c.getString("created_at");
                    String updated_at = c.getString("updated_at");

                    HashMap<String, String> data = new HashMap<>();

                    data.put("id", id);
                    data.put("name", name);
                    data.put("email", email);
                    data.put("location", location);

                    dataList.add(data);

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

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);
            // Dismiss the progress dialog
            if (pDialog.isShowing())
                pDialog.dismiss();
            /**
             * Updating parsed JSON data into ListView
             * */
            ListAdapter adapter = new SimpleAdapter(
                    JsonActivity.this, dataList,
                    R.layout.list_item, new String[]{"name", "email",
                    "location", "id"}, new int[]{R.id.name,
                    R.id.email, R.id.location, R.id.id});

            lv.setAdapter(adapter);
        }

    }
}